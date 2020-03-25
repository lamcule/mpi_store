<?php

namespace Modules\App\Http\Controllers\Admin;

use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\File;
use League\Flysystem\Filesystem;
use Mockery\Exception;
use Modules\App\Http\Requests\CreateAppRequest;
use Modules\App\Http\Requests\UpdateAppRequest;
use Modules\App\Jobs\UploadToDropbox;
use Modules\App\Repositories\AppDetailRepository;
use Modules\App\Repositories\AppRepository;
use Modules\Media\Repositories\MediaRepository;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DOMDocument;

class AppController extends Controller
{
    private $app;
    private $appDetail;
    private $media;

    public function __construct(AppRepository $app, AppDetailRepository $appDetail, MediaRepository $media)
    {
        $this->app = $app;
        $this->appDetail = $appDetail;
        $this->media = $media;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $apps = $this->app->all()->load('appDetail');
        foreach ($apps as $app) {
            if (!empty($app->appDetail)) {
                foreach ($app->appDetail as $value) {
                    if ($value->os == 'iOS') {
                        $app['iOS_version'] = $value->version;
                    }
                    if ($value->os == 'android') {
                        $app['android_version'] = $value->version;
                    }
                }
            }
        }
        return view('app::admin.index', compact('apps'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('app::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateAppRequest $request)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            $data = $request->all();
//            storage file
            $avatar = [];
            $media = [];
            $iOS = [];
            $android = [];
            $title = $this->format_string($request->title);
            $assetPath = 'asset/' . $title;
            $destinationPath = public_path($assetPath);
            if ($request->hasFile('avatar')) {
                $avatar_request = $request->file('avatar');
                $avatar_name = $avatar_request->getClientOriginalName();
                $avatar_request->move($destinationPath, $avatar_name);
                $avatar['path'] = $assetPath . '/' . $avatar_name;
                $avatar['name'] = $avatar_name;
            }
            if ($request->images_screen) {
                foreach ($request->images_screen as $image) {
                    $image_name = $image->getClientOriginalName();
                    $image->move($destinationPath, $image_name);
                    $images['path'] = $assetPath . '/' . $image_name;
                    $images['name'] = $image_name;
                    $media[] = $images;
                }
            }
            if ($request->hasFile('iOS_file')) {
                $iOS_file_request = $request->file('iOS_file');
                $iOS_file_name = $iOS_file_request->getClientOriginalName();
                $iOS_file_request->move($destinationPath, $iOS_file_name);
                $path_iOS = $assetPath . '/' . $iOS_file_name;
                $iOS['name'] = $iOS_file_name;
                $iOS['path'] = $this->getFileDownloadIOS($iOS['name'], $assetPath, $path_iOS);
            }
            if ($request->hasFile('android_file')) {
                $android_file_request = $request->file('android_file');
                $android_file_name = $android_file_request->getClientOriginalName();
                $android_file_request->move($destinationPath, $android_file_name);
                $android['name'] = $android_file_name;
                $android['path'] = $assetPath . '/' . $android_file_name;
            }
//            create app
            $app = [
                'title' => $data['title'],
                'description' => $data['description'],
                'avatar' => !empty($avatar) ? $avatar['path'] : null,
                'user_id' => $user_id,
                'status' => 1
            ];
            $this->app->create($app);
//            create app detail
            $app_id = $this->app->all()->last();
            $app_id = $app_id->id;
            $iOSAppDetail = [
                'app_id' => $app_id,
                'os' => 'iOS',
                'version' => $data['iOS_version'],
                'path' => !empty($iOS) ? $iOS['path'] : null,
                'file_name' => !empty($iOS) ? $iOS['name'] : null
            ];
            $androidAppDetail = [
                'app_id' => $app_id,
                'os' => 'android',
                'version' => $data['android_version'],
                'path' => !empty($android) ? $android['path'] : null,
                'file_name' => !empty($android) ? $android['name'] : null
            ];
            $this->appDetail->create($iOSAppDetail);
            $this->appDetail->create($androidAppDetail);
//            create images of app
            $mediaCreate = [];
            if (!empty($media)) {
                foreach ($media as $value) {
                    $mediaCreate[] = [
                        'app_id' => $app_id,
                        'path' => $value['path'],
                        'file_name' => $value['name']
                    ];
                }
                $this->media->insertMedia($mediaCreate);
            }
            DB::commit();
            return redirect()->route('admin.app.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Tạo ứng dụng lỗi.');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('app::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $app = $this->app->find($id)->load('appDetail', 'media');
        if (!empty($app->appDetail)) {
            foreach ($app->appDetail as $value) {
                if ($value->os == 'iOS') {
                    $app['iOS_version'] = $value->version;
                    $app['iOS_path'] = $value->path;
                    $app['iOS_file_name'] = $value->file_name;
                    $app['iOS_date'] = $value->updated_at;
                }
                if ($value->os == 'android') {
                    $app['android_version'] = $value->version;
                    $app['android_path'] = $value->path;
                    $app['android_file_name'] = $value->file_name;
                    $app['android_date'] = $value->updated_at;
                }
            }
        }
        return view('app::admin.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateAppRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            $data = $request->all();
//            storage file
            $avatar = [];
            $media = [];
            $iOS = [];
            $android = [];
            $title = $this->format_string($request->title);
            $assetPath = 'asset/' . $title;
            $destinationPath = public_path($assetPath);
            if ($request->hasFile('avatar')) {
                $avatar_request = $request->file('avatar');
                $avatar_name = $avatar_request->getClientOriginalName();
                $avatar_request->move($destinationPath, $avatar_name);
                $avatar['path'] = $assetPath . '/' . $avatar_name;
                $avatar['name'] = $avatar_name;
            }
            if ($request->images_screen) {
                foreach ($request->images_screen as $image) {
                    $image_name = $image->getClientOriginalName();
                    $image->move($destinationPath, $image_name);
                    $images['path'] = $assetPath . '/' . $image_name;
                    $images['name'] = $image_name;
                    $media[] = $images;
                }
            }
            if ($request->hasFile('iOS_file')) {
                $iOS_file_request = $request->file('iOS_file');
                $iOS_file_name = $iOS_file_request->getClientOriginalName();
                $iOS_file_request->move($destinationPath, $iOS_file_name);
                $path_iOS = $assetPath . '/' . $iOS_file_name;
                $iOS['name'] = $iOS_file_name;
                $iOS['path'] = $this->getFileDownloadIOS($iOS['name'], $assetPath, $path_iOS);
            }
            if ($request->hasFile('android_file')) {
                $android_file_request = $request->file('android_file');
                $android_file_name = $android_file_request->getClientOriginalName();
                $android_file_request->move($destinationPath, $android_file_name);
                $android['name'] = $android_file_name;
                $android['path'] = $assetPath . '/' . $android_file_name;
            }
//            update app
            $app = [
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => $user_id,
                'status' => 1
            ];
            if ($avatar) {
                $app['avatar'] = $avatar['path'];
            }
            $this->app->update($app, $id);
//            update app detail
            $iOSAppDetail['version'] = $data['iOS_version'];
            if ($iOS) {
                $iOSAppDetail['path'] = $iOS['path'];
                $iOSAppDetail['file_name'] = $iOS['name'];
            }
            $this->appDetail->update($iOSAppDetail, $this->appDetail->getAppDetail($id, 'iOS')->first()->id);
            $androidAppDetail['version'] = $data['android_version'];
            if ($android) {
                $androidAppDetail['path'] = $android['path'];
                $androidAppDetail['file_name'] = $android['name'];
            }
            $this->appDetail->update($androidAppDetail, $this->appDetail->getAppDetail($id, 'android')->first()->id);

//            update images of app
            $images_old = $request->image_old;
            $app_current = $this->app->find($id)->load('media');
            if (!empty($app_current->media)) {
                foreach ($app_current->media as $val) {
                    if (!in_array($val->id, $images_old)) {
                        $this->media->delete($val->id);
                    }
                }
            }
            $mediaCreate = [];
            if (!empty($media)) {
                foreach ($media as $value) {
                    $mediaCreate[] = [
                        'app_id' => $id,
                        'path' => $value['path'],
                        'file_name' => $value['name']
                    ];
                }
                $this->media->insertMedia($mediaCreate);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Ứng dụng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Cập nhật ứng dụng lỗi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $apps = $this->app->searchApp($request->text_search);
        foreach ($apps as $app) {
            if (!empty($app->appDetail)) {
                foreach ($app->appDetail as $value) {
                    if ($value->os = 'iOS') {
                        $app['iOS_version'] = $value->version;
                    }
                    if ($value->os = 'android') {
                        $app['android_version'] = $value->version;
                    }
                }
            }
        }
        return view('app::admin.index', compact('apps'));
    }

    public function getFileDownloadIOS($file_name, $folder, $path_name)
    {
        $fileUnZip = str_replace(".ipa", "", $file_name);
        // get content file Info
        $content = $this->getContentFileInfo($file_name, $folder, $path_name);

        // get bundle id, bundle name and url
        $value = $this->getValueFromAppInfo($file_name, $folder, $content);

        // write content xml to file plist
        $plist_path = $folder . '/' . $fileUnZip . '.plist';
        $xmlString = $this->loadContentToFilePlist($value, $plist_path);

        /* upload to dropbox */

        $pathDropbox = $this->uploadToDropbox($fileUnZip, $xmlString);


        // delete folder tmp
        File::deleteDirectory(public_path($folder) . '/' . $fileUnZip);
        return $pathDropbox;
    }

    /**
     * @param $file_name
     * @param $folder
     * @param $path_name
     * @return array|mixed|string
     */
    private function getContentFileInfo($file_name, $folder, $path_name)
    {
        $uploads_folder = public_path($folder);
        $fileUnZip = str_replace(".ipa", "", $file_name);
        Zipper::make(public_path($path_name))->extractTo($uploads_folder . '/' . $fileUnZip);
        $filesInFolder = File::allFiles($uploads_folder . '/' . $fileUnZip);

        // get content in file Info.plist
        $content = [];
        foreach ($filesInFolder as $key => $file) {
            if (substr_count($file->getRelativePathname(), '/') == 2 && strpos($file->getRelativePathname(), "Info.plist") !== false) {
                $path = $file->getRelativePath();
                $url = $file->getRelativePathname();
                $checkFile = mime_content_type($uploads_folder . "/$fileUnZip/$url");
                if (strpos($checkFile, "xml")) {
                    $content = $file->getContents();
                    $xmlNode = simplexml_load_string($content);
                    $content = str_replace("\t", "", $content);
                    $content = str_replace(" ", "", $content);
                    $content = explode("\n", $content);
                } else {
                    $public_path = public_path($folder . '/' . $fileUnZip . '/' . $path . '/Info.plist');
                    exec("plistutil -i $public_path", $out);
                    $content = implode(' ', $out);
                    $content = str_replace("\t", "", $content);
                    $content = explode(" ", $content);
                }
            }
        }
        return $content;
    }

    /**
     * @param $file_name
     * @param $folder
     * @param $content
     * @return array
     */
    private function getValueFromAppInfo($file_name, $folder, $content)
    {
        $bundleId = "";
        $name = "";
        foreach ($content as $key => $value) {
            if (strpos($value, "CFBundleIdentifier") !== false) {
                $bundleId = strip_tags($content[$key + 1]);
            }
            if (strpos($value, "CFBundleName") !== false) {
                $name = strip_tags($content[$key + 1]);
            }
        }
        $url = asset($folder . '/' . $file_name);
        $valuesInfo = [
            'bundleId' => $bundleId,
            'bundleName' => $name,
            'url' => $url
        ];
        return $valuesInfo;
    }

    /**
     * @param $value
     * @param $plist_path
     * @return bool
     */
    private function loadContentToFilePlist($value, $plist_path)
    {
        $bundleId = $value['bundleId'];
        $name = $value['bundleName'];
        $url = $value['url'];
        Storage::disk('plist')->put($plist_path, '');
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
        <plist version="1.0">
        <dict>
            <key>items</key>
            <array>
               <dict>
                    <key>assets</key>
                    <array>
                        <dict>
                            <key>kind</key>
                            <string>software-package</string>
                            <key>url</key>
                            <string>' . $url . '</string>
                        </dict>
                    </array>
                    <key>metadata</key>
                    <dict>
                        <key>bundle-identifier</key>
                        <string>' . $bundleId . '</string>
                        <key>bundle-version</key>
                        <string>4.0</string>
                        <key>kind</key>
                        <string>software</string>
                        <key>subtitle</key>
                        <string>41A472</string>
                        <key>title</key>
                        <string>' . $name . '</string>
                    </dict>
                </dict>
            </array>
        </dict>
        </plist>';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = TRUE;
        $dom->loadXML($xmlString);
        $path = public_path($plist_path);
        $dom->save($path);
        return $xmlString;
    }

    /**
     * @param $fileUnZip
     * @param $xmlString
     * @return mixed|string
     */
    private function uploadToDropbox($fileUnZip, $xmlString)
    {
        $path = UploadToDropbox::dispatch($fileUnZip, $xmlString);
        return $path;
    }

    function format_string($str)
    {

        $unicode = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd' => 'đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i' => 'í|ì|ỉ|ĩ|ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D' => 'Đ',

            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);

        }
        $str = str_replace(' ', '_', $str);

        return $str;
    }
}
