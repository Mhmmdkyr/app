<?php

namespace App\Http\Controllers\admin;

use App\Models\Language as ModelsLanguage;
use App\Models\Setting;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\Language;

class Settings extends AdminController
{
    public $globals = ['timezone', 'color', 'mail', 'shortener', 'select_domain', 'shortener_domain', 'recaptcha', 'footer_html', 'header_html'];
    public function index(Request $request)
    {
        $timezones = file_get_contents(public_path('backend/json/timezones.json'));
        $timezones = json_decode($timezones);
        $lang = config('app.default_lang.id');
        if ($request->has('lang') && $request->lang) {
            $lang = $request->lang;
            $settings = Setting::where('language_id', $lang)->OrWhere('language_id', 0)->get()->pluck('value', 'keyword');
        } else {
            $settings = Setting::where('language_id', config('app.default_lang.id'))->OrWhere('language_id', 0)->get()->pluck('value', 'keyword');
        }
        return $this->render("settings.settings", ['imager' => true, 'timezones' => $timezones, 'settings' => $settings, 'lang' => $lang, 'globals' => $this->globals]);
    }

    public function save(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $validate = $request->validate([
            'settings.title' => 'required',
            'language_id' => 'required'
        ], [
            'settings.title.required' => __('"Site Title" is required. Please check and try again.'),
            'language_id.required' => __('"Language" is required. Please check and try again.')
        ]);
        foreach ($request->settings as $key => $set) {
            $lang_id = in_array($key, $this->globals) ? '0' : $request->language_id;
            $setting = Setting::where('keyword', $key)->where('language_id', $lang_id)->first();

            if (is_array($set)) {
                $set = json_encode($set);
            }
            if ($setting) {

                $setting->value = $set;
                $setting->save();
            } else {

                $fields['keyword'] = $key;
                $fields['value'] = $set;
                $fields['language_id'] = in_array($key, $this->globals) ? '0' : $request->language_id;
                Setting::create($fields);
            }
        }
        $request->session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.settings.index');
    }

    public function adSpaces()
    {
        $spaces = [
            'home' => [
                'title' => __('Home Ads'),
                'spaces' => [
                    'top' => [
                        'label' => __('Home Top Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ],
                    'middle' => [
                        'label' => __('Home Middle Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ],
                    'bottom' => [
                        'label' => __('Home Bottom Ads (Horizontal)'),
                        'desktop' => '1400x150',
                        'mobile' => '320x50',
                    ]
                ]
            ],
            'post' => [
                'title' => __('Post Detail Ads'),
                'spaces' => [
                    'bottom' =>  [
                        'label' => __('Post Detail Bottom Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ],
                    'middle' => [
                        'label' => __('Post Detail Middle Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ]
                ]
            ],
            'category' => [
                'title' => __('Category Page Ads'),
                'spaces' => [
                    'bottom' => [
                        'label' => __('Category Page Bottom Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ],
                    'middle' => [
                        'label' => __('Category Page Middle Ads (Horizontal)'),
                        'desktop' => '1020x100',
                        'mobile' => '320x50',
                    ]
                ]
            ],
            'sidebar' => [
                'title' => __('Sidebar Ads'),
                'spaces' => [
                    'top' => [
                        'label' => __('Sidebar Top Ads (Vertical)'),
                        'desktop' => '320x250',
                        'mobile' => false,
                    ],
                    'bottom' => [
                        'label' => __('Sidebar Bottom Ads (Vertical)'),
                        'desktop' => '320x250',
                        'mobile' => false,
                    ]
                ]
            ]
        ];
        return $this->render("settings.ad-spaces", ['imager' => true, 'spaces' => $spaces]);
    }
    public function adSpacesSave(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        Setting::where('keyword', 'ads')->delete();
        $arr = [
            'keyword' => 'ads',
            'value' => json_encode($request->ads),
            'language_id' => 0
        ];
        Setting::create($arr);
        $request->session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.settings.adspaces');
    }

    public function localizations()
    {
        return $this->render("settings.localizations", []);
    }

    public function saveLanguage(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $validatedData = $request->validate([
            'title' => ['required',  'max:50'],
            'slug' => ['required', 'max:3'],
            'default' => ['required', 'max:1'],
            'active' => ['required', 'max:1'],
            'rtl' => ['required', 'max:1']
        ]);
        try {
            if ($request->has('id') && $request->id != '') {
                // Edit Language
                if ($request->default) {
                    ModelsLanguage::where('default', 1)->update(['default' => 0]);
                }
                ModelsLanguage::where('id', $request->id)->update($request->only(['title', 'slug', 'default', 'active', 'rtl']));
            } else {
                // Add New Lang
                $add_lang = ModelsLanguage::create($request->only(['title', 'slug', 'default', 'active', 'rtl']));
                if ($add_lang) {
                    $settings = Setting::where('language_id', 1)->get();
                    foreach ($settings as $setting) {
                        Setting::create(['keyword' => $setting->keyword, 'value' => is_object($setting->value) ? json_encode($setting->value) : $setting->value, 'language_id' => $add_lang->id]);
                    }
                    $main_json = resource_path('lang') . "/original.json";
                    $content = file_get_contents($main_json);
                    file_put_contents(resource_path('lang') . "/" . $request->slug . ".json", $content);
                }
            }
            session()->flash('status', __('Your changes have been saved'));
        } catch (\Throwable $th) {
            session()->flash('status', $th);
        }
        return redirect()->route('admin.settings.localizations');
    }

    public function editTranslations(Request $request, $slug)
    {
        $original_lang_file = resource_path('lang/original.json');
        $original_lang_file = file_get_contents($original_lang_file);
        $original_translations = json_decode($original_lang_file, true);


        $lang_file = resource_path('lang/' . $slug . ".json");
        $lang_file = file_get_contents($lang_file);
        $translations = json_decode($lang_file, true);
        return $this->render("settings.edit-translates", ['translates' => $translations, 'originals' => $original_translations]);
    }

    public function saveTranslations(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $add = [];
        if ($request->has('slug')) {
            foreach ($request->keyword as $k => $key) {
                if (isset($request->value[$k]) && !is_array($request->value[$k]) && isset($request->keyword[$k]) && !is_array($request->keyword[$k])) {
                    $add[$request->keyword[$k]] = $request->value[$k];
                } elseif (is_array($request->value[$k]) && is_array($request->keyword[$k])) {
                    foreach ($request->keyword[$k] as $kk => $kkey) {
                        $add_arr[$request->keyword[$k][$kk]] = $request->value[$k][$kk];
                    }
                    $add[$k] = $add_arr;
                }
            }
            $content = json_encode($add, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents(resource_path('lang') . "/" . $request->slug . ".json", $content);
        }
        session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.settings.localizations');
    }

    public function deleteLanguage(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        if (!$request->has('id')) {
            return false;
        }
        $id = $request->id;
        if ($request->id == 1) {
            return response()->json(['message' => __('System language cannot be deleted')]);
        }
        ModelsLanguage::where('id', $id)->delete();
        Setting::where('language_id', $id)->delete();
        $default = ModelsLanguage::where('default', 1)->first();
        if (!$default) {
            ModelsLanguage::where('id', 1)->update(['default' => 1]);
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }
    public function dbBackups()
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $backups = glob(storage_path('backups') . "/*.sql");
        $db = [];
        foreach ($backups as $back) {
            $d['dir'] = $back;
            $d['name'] = pathinfo($back)['basename'];
            $db[] = $d;
        }
        return $this->render("settings.backups", ['backups' => array_reverse($db)]);
    }

    public function downloadBackup(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $file = storage_path('backups') . "/" . $request->file;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $request->file . "\"");
        readfile($file);
    }

    public function getBackup()
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $tables = [
            'categories',
            'comments',
            'languages',
            'newsletters',
            'pages',
            'posts',
            'post_categories',
            'roles',
            'settings',
            'themes',
            'users',
        ];

        $structure = '';
        $data = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";

            $show_table_result = DB::select(DB::raw($show_table_query));

            foreach ($show_table_result as $show_table_row) {
                $show_table_row = (array)$show_table_row;
                $structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table;
            $records = DB::select(DB::raw($select_query));

            foreach ($records as $record) {
                $record = (array)$record;
                $table_column_array = array_keys($record);
                foreach ($table_column_array as $key => $name) {
                    $table_column_array[$key] = '`' . $table_column_array[$key] . '`';
                }

                $table_value_array = array_values($record);
                $data .= "\nINSERT INTO $table (";

                $data .= "" . implode(", ", $table_column_array) . ") VALUES \n";

                foreach ($table_value_array as $key => $record_column)
                    $table_value_array[$key] = addslashes($record_column);

                $data .= "('" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('Y-m-d') . '.sql';
        $path = storage_path('backups') . "/" . $file_name;
        touch($path);
        $file_handle = fopen($path, 'w + ');

        $output = $structure . $data;
        fwrite($file_handle, $output);
        fclose($file_handle);
        session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.settings.dbbackups');
    }
}
