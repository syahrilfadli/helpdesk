<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Date;

class Utility extends Model
{
    public static function getValByName($key)
    {
        $setting = Utility::settings();

        if(!isset($_ENV[$key]) || empty($_ENV[$key]))
        {
            $_ENV[$key] = '';
        }

        return $_ENV[$key];
    }

    public static function getSettingValByName($key)
    {
        $setting = self::settings();

        if(!isset($setting[$key]) || empty($setting[$key]))
        {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function settings()
    {
        $user = \Auth::user();


        $data = DB::table('settings')->get();

        $settings = [
            "Knowlwdge_Base" => "on",
            "FAQ" => "on",
            "SITE_RTL" => "off",
            "dark_logo" => "logo-dark.png",
            "light_logo" => "logo-light.png",
            "color" => "theme-3",
            'DEFAULT_LANG' => 'en',
            'CHAT_MODULE' => "yes",
            'FOOTER_TEXT' => "© Copyright TICKTGO 2023",
            'company_name' => "",
            'company_email' => "",
            'cust_theme_bg'=> "on",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png,xlsx,xls,csv,pdf",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "resolve_status"=>"0",
            "PUSHER_APP_KEY" => "",
            "PUSHER_APP_CLUSTER" => "",
            "PUSHER_APP_SECRET" => "",
            "PUSHER_APP_ID" => "",
            "is_enabled" => "",
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices, please contact us',
            'contactus_url' => '#',
            'disable_lang'=>'',
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }


    public static function non_auth_settings($id)
    {
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', $id);
        $data = $data->get();
        $res = [];
        foreach ($data as $key => $value) {
            $res[$value->name] = $value->value;
        }

        return $res;
    }

    public static function addNewData()
    {
        \Artisan::call('cache:forget spatie.permission.cache');
        \Artisan::call('cache:clear');

        $usr            = \Auth::user();
        $arrPermissions = [

            "manage-knowledge",
            "create-knowledge",
            "edit-knowledge",
            "delete-knowledge",
            "manage-knowledgecategory",
            "create-knowledgecategory",
            "edit-knowledgecategory",
            "delete-knowledgecategory",

        ];
        foreach ($arrPermissions as $ap) {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if (empty($permission)) {
                Permission::create(['name' => $ap]);
            }
        }
        $adminRole          = Role::where('name', 'LIKE', 'Admin')->first();
        $adminPermissions   = $adminRole->getPermissionNames()->toArray();
        $adminNewPermission = [
            "manage-knowledge",
            "create-knowledge",
            "edit-knowledge",
            "delete-knowledge",
            "manage-knowledgecategory",
            "create-knowledgecategory",
            "edit-knowledgecategory",
            "delete-knowledgecategory",
        ];
        foreach ($adminNewPermission as $op) {
            // check if permission is not assign to owner then assign.
            if (!in_array($op, $adminPermissions)) {
                $permission = Permission::findByName($op);
                $adminRole->givePermissionTo($permission);
            }
        }
        $agentRole          = Role::where('name', 'LIKE', 'Agent')->first();
        $agentPermissions   = $agentRole->getPermissionNames()->toArray();
        $agentNewPermission = [

        ];
        foreach ($agentNewPermission as $op) {
            // check if permission is not assign to owner then assign.
            if (!in_array($op, $agentPermissions)) {
                $permission = Permission::findByName($op);
                $agentRole->givePermissionTo($permission);
            }
        }
    }

    public static function get_superadmin_logo(){
        $is_dark_mode = self::getSettingValByName('cust_darklayout');
        if($is_dark_mode == 'on'){
            return 'logo-light.png';
        }else{
            return 'logo-dark.png';
        }
    }

    public static function defaultEmail()
    {
        // Email Template
        $emailTemplate = [
            'New User',
            'New Ticket',
            'New Ticket Reply',
            // 'Lead Assign',
        ];

        foreach ($emailTemplate as $eTemp) {
            EmailTemplate::create(
                [
                    'name' => $eTemp,
                    'from' => env('APP_NAME'),
                    'slug' => strtolower(str_replace(' ', '_', $eTemp)),
                    'created_by' => 1,
                ]
            );
        }

        $defaultTemplate = [
            'New User' => [
                'subject' => 'Login Detail',
                'lang' => [
                    'ar' => '<p>مرحبا ، مرحبا بك في {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>البريد الالكتروني : {email}</p>
                            <p>كلمة السرية : {password}</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>شكرا</p>
                            <p>{ app_name }</p>',
                    'da' => '<p>Hej, velkommen til { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>E-mail: { email }-</p>
                            <p>kodeord: { password }</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Tak.</p>
                            <p>{ app_name }</p>',
                    'de' => '<p>Hallo, Willkommen bei {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>E-Mail: {email}</p>
                            <p>Kennwort: {password}</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Danke,</p>
                            <p>{Anwendungsname}</p>',
                    'en' => '<p>Hello,&nbsp;<br>Welcome to {app_name}.</p><p><b>Email </b>: {email}<br><b>Password</b> : {password}</p><p>{app_url}</p><p>Thanks,<br>{app_name}</p>',
                    'es' => '<p>Hola, Bienvenido a {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>Correo electr&oacute;nico: {email}</p>
                            <p>Contrase&ntilde;a: {password}</p>
                            <p>&nbsp;</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Gracias,</p>
                            <p>{app_name}</p>',
                    'fr' => '<p>Bonjour, Bienvenue dans { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>E-mail: { email }</p>
                            <p>Mot de passe: { password }</p>
                            <p>{ adresse_url }</p>
                            <p>&nbsp;</p>
                            <p>Merci,</p>
                            <p>{ nom_app }</p>',
                    'it' => '<p>Ciao, Benvenuti in {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>Email: {email} Password: {password}</p>
                            <p>&nbsp;</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Grazie,</p>
                            <p>{app_name}</p>',
                    'ja' => '<p>こんにちは、 {app_name}へようこそ。</p>
                            <p>&nbsp;</p>
                            <p>E メール : {email}</p>
                            <p>パスワード : {password}</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>ありがとう。</p>
                            <p>{app_name}</p>',
                    'nl' => '<p>Hallo, Welkom bij { app_name }.</p>
                                <p>&nbsp;</p>
                                <p>E-mail: { email }</p>
                                <p>Wachtwoord: { password }</p>
                                <p>{ app_url }</p>
                                <p>&nbsp;</p>
                                <p>Bedankt.</p>
                                <p>{ app_name }</p>',
                    'pl' => '<p>Witaj, Witamy w aplikacji {app_name }.</p>
                            <p>&nbsp;</p>
                            <p>E-mail: {email }</p>
                            <p>Hasło: {password }</p>
                            <p>{app_url }</p>
                            <p>&nbsp;</p>
                            <p>Dziękuję,</p>
                            <p>{app_name }</p>',
                    'ru' => '<p>Здравствуйте, Добро пожаловать в { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>Адрес электронной почты: { email }</p>
                            <p>Пароль: { password }</p>
                            <p>&nbsp;</p>
                            <p>{ app_url }</p>
                            <p>&nbsp;</p>
                            <p>Спасибо.</p>
                            <p>{ имя_программы }</p>',
                    'pt' => '<p>Ol&aacute;, Bem-vindo a {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>E-mail: {email}</p>
                            <p>Senha: {senha}</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Obrigado,</p>
                            <p>{app_name}</p>
                            <p>{ имя_программы }</p>',
                    'tr' => '<p>Ol, { app_name } olanağına hoş geldiniz.</p>
                            <p>&nbsp;</p>
                            <p>E-posta: {email}</p>
                            <p>Parola: {password}</p>
                            <p>{app_url}</p>
                            <p>&nbsp;</p>
                            <p>Teşekkür ederim.</p>
                            <p>{app_name}</p>
                            <p>{ program_adı }</p>',
                    'he' => '<p>שלום, &nbsp;<br>ברוכים הבאים אל {app_name}.</p><p><b>דואל </b>: {הדוא " ל}<br><b>סיסמה</b> : {password}</p><p>{app_url}</p><p>תודה,<br>{app_name}</p>',
                    'zh' => '<p>您好，<br>欢迎访问 {app_name}。</p><p><b>电子邮件 </b>: {email}<br><b>密码</b> : {password}</p><p>{app_url}</p><p>谢谢，<br>{app_name}</p>',
                    'pt-br' => '<p>Ol&aacute;, Bem-vindo a {app_name}.</p>
                                <p>&nbsp;</p>
                                <p>E-mail: {email}</p>
                                <p>Senha: {senha}</p>
                                <p>{app_url}</p>
                                <p>&nbsp;</p>
                                <p>Obrigado,</p>
                                <p>{app_name}</p>
                                <p>{ имя_программы }</p>',

                ],
            ],
            'New Ticket' => [
                'subject' => 'Ticket Detail',
                'lang' => [
                    'ar' => '<p>مرحبا ، مرحبا بك في { app_name }.</p>
                            <p> </p>
                            <p>البريد الالكتروني : { mail }</p>
                            <p>كلمة السرية : { password }</p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>شكرا</p>
                            <p>{ app_name }</p>',
                    'da' => '<p>Hej, velkommen til { app_name }.</p>
                            <p> </p>
                            <p>E-mail: { email }-</p>
                            <p>kodeord: { password }</p>
                            <p>{ app_url }</p>
                            <p> </p>
                            <p>Tak.</p>
                            <p>{ app_name }</p>',
                    'de' => '<p>Hallo, Willkommen bei {app_name}.</p>
                            <p> </p>
                            <p>E-Mail: {email}</p>
                            <p>Kennwort: {password}</p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>Danke,</p>
                            <p>{Anwendungsname}</p>',
                    'en' => '<p>Hello,&nbsp;<br>Welcome to {app_name}.</p><p>{ticket_name} </p><p>{ticket_id} </p><p><b>Email </b>: {email}<br><b>Password</b> : {password}</p><p>{app_url}</p><p>Thanks,<br>{app_name}</p>',
                    'es' => '<p>Hola, Bienvenido a {app_name}.</p>
                            <p> </p>
                            <p>Correo electrónico: {email}</p>
                            <p>Contraseña: {password}</p>
                            <p> </p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>Gracias,</p>
                            <p>{app_name}</p>',
                    'fr' => '<p>Bonjour, Bienvenue dans {app_name}.</p>
                            <p> </p>
                            <p>E-mail: { email }</p>
                            <p>Mot de passe: { password }</p>
                            <p>{ adresse_url }</p>
                            <p> </p>
                            <p>Merci,</p>
                            <p>{ nom_app }</p>',
                    'it' => '<p>Ciao, Benvenuti in {app_name}.</p>
                            <p> </p>
                            <p>Email: {email} Password: {password}</p>
                            <p> </p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>Grazie,</p>
                            <p>{app_name}</p>',
                    'ja' => '<p>こんにちは、 {app_name}へようこそ。</p>
                            <p> </p>
                            <p>E メール : {email}</p>
                            <p>パスワード : {password}</p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>ありがとう。</p>
                            <p>{app_name}</p>',
                    'nl' => '<p>Hallo, Welkom bij { app_name }.</p>
                            <p> </p>
                            <p>E-mail: { email }</p>
                            <p>Wachtwoord: { password }</p>
                            <p>{ app_url }</p>
                            <p> </p>
                            <p>Bedankt.</p>
                            <p>{ app_name }</p>',
                    'pl' => '<p>Witaj, Witamy w aplikacji {app_name }.</p>
                            <p> </p>
                            <p>E-mail: {email }</p>
                            <p>Hasło: {password }</p>
                            <p>{app_url }</p>
                            <p> </p>
                            <p>Dziękuję,</p>
                            <p>{app_name }</p>',
                    'ru' => '<p>Здравствуйте, Добро пожаловать в { app_name }.</p>
                            <p> </p>
                            <p>Адрес электронной почты: { email }</p>
                            <p>Пароль: { password }</p>
                            <p> </p>
                            <p>{ app_url }</p>
                            <p> </p>
                            <p>Спасибо.</p>
                            <p>{ имя_программы }</p>',
                    'pt' => '<p>Olá, Bem-vindo a {app_name}.</p>
                            <p> </p>
                            <p>E-mail: {email}</p>
                            <p>Senha: {senha}</p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>Obrigado,</p>
                            <p>{app_name}</p>
                            <p>{ имя_программы }</p>',
                    'tr' => '<p>Merhaba, { app_name } olanağına hoş geldiniz.</p>
                            <p> </p>
                            <p>E-posta: { email }</p>
                            <p>Parola: { password }</p>
                            <p>{app_url}</p>
                            <p> </p>
                            <p>Teşekkür ederim.</p>
                            <p>{app_name}</p>
                            <p>{ program_adı }</p>',
                    'he' => '<p>שלום, &nbsp;<br>ברוכים הבאים אל {app_name}.</p><p>{ticket_name} </p><p>{ticket_id} </p><p><b>דואל </b>: {דואל}<br><b>סיסמה</b> : {password}</p><p>{app_url}</p><p>תודה,<br>{app_name}</p>',
                    'zh' => '<p>Hello，<br>欢迎访问 {app_name}。</p><p>{ticket_name} </p><p>{ticket_id} </p><p><b>电子邮件 </b>: {email}<br><b>密码</b> : {password}</p><p>{app_url}</p><p>谢谢，<br>{app_name}</p>',
                    'pt-br' => '<p>Olá, Bem-vindo a {app_name}.</p>
                                <p> </p>
                                <p>E-mail: {email}</p>
                                <p>Senha: {senha}</p>
                                <p>{app_url}</p>
                                <p> </p>
                                <p>Obrigado,</p>
                                <p>{app_name}</p>
                                <p>{ имя_программы }</p>',

                ],
            ],
            'New Ticket Reply' => [
                'subject' => 'Ticket Detail',
                'lang' => [
                    'ar' => '<p>مرحبا ، مرحبا بك في { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>{ ticket_name }</p>
                            <p>{ ticket_id }</p>
                            <p>&nbsp;</p>
                            <p>الوصف : { ticket_description }</p>
                            <p>&nbsp;</p>
                            <p>شكرا</p>
                            <p>{ app_name }</p>',
                    'da' => '<p>Hej, velkommen til { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>{ ticket_name }</p>
                            <p>{ ticket_id }</p>
                            <p>&nbsp;</p>
                            <p>Beskrivelse: { ticket_description }</p>
                            <p>&nbsp;</p>
                            <p>Tak.</p>
                            <p>{ app_name }</p>',
                    'de' => '<p>Hallo, Willkommen bei {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>{ticketname}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Beschreibung: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Danke,</p>
                            <p>{Anwendungsname}</p>',
                    'en' => '<p>Hello,&nbsp;<br />Welcome to {app_name}.</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p><strong>Description</strong> : {ticket_description}</p>
                            <p>Thanks,<br />{app_name}</p>',
                    'es' => '<p>Hola, Bienvenido a {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Descripci&oacute;n: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Gracias,</p>
                            <p>{app_name}</p>',
                    'fr' => '<p>Hola, Bienvenido a {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Descripci&oacute;n: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Gracias,</p>
                            <p>{app_name}</p>',
                    'it' => '<p>Ciao, Benvenuti in {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Descrizione: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Grazie,</p>
                            <p>{app_name}</p>',
                    'ja' => '<p>こんにちは、 {app_name}へようこそ。</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>説明 : {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>ありがとう。</p>
                            <p>{app_name}</p>',
                    'nl' => '<p>Hallo, Welkom bij { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>{ ticket_name }</p>
                            <p>{ ticket_id }</p>
                            <p>&nbsp;</p>
                            <p>Beschrijving: { ticket_description }</p>
                            <p>&nbsp;</p>
                            <p>Bedankt.</p>
                            <p>{ app_name }</p>',
                    'pl' => '<p>Witaj, Witamy w aplikacji {app_name }.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name }</p>
                            <p>{ticket_id }</p>
                            <p>&nbsp;</p>
                            <p>Opis: {ticket_description }</p>
                            <p>&nbsp;</p>
                            <p>Dziękuję,</p>
                            <p>{app_name }</p>',
                    'ru' => '<p>Здравствуйте, Добро пожаловать в { app_name }.</p>
                            <p>&nbsp;</p>
                            <p>Witaj, Witamy w aplikacji {app_name }.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name }</p>
                            <p>{ticket_id }</p>
                            <p>&nbsp;</p>
                            <p>Opis: {ticket_description }</p>
                            <p>&nbsp;</p>
                            <p>Dziękuję,</p>
                            <p>{app_name }</p>',
                    'pt' => '<p>Ol&aacute;, Bem-vindo a {app_name}.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Descri&ccedil;&atilde;o: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Obrigado,</p>
                            <p>{app_name}</p>',
                    'tr' => '<p>Ol, { app_name } olanağına hoş geldiniz.</p>
                            <p>&nbsp;</p>
                            <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p>&nbsp;</p>
                            <p>Descri &ccedil; &atlde; o: {ticket_description}</p>
                            <p>&nbsp;</p>
                            <p>Teşekkür ederim.</p>
                            <p>{app_name}</p>',
                    'he' => '<p>שלום, &nbsp;<br />ברוכים הבאים ל - {app_name}.</p> <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p><strong>תיאור</strong> : {ticket_description}</p>
                            <p>תודה,<br />{app_name}</p>',
                    'zh' => '<p>您好，<br />欢迎访问 {app_name}。</p> <p>{ticket_name}</p>
                            <p>{ticket_id}</p>
                            <p><strong>描述</strong> : {ticket_description}</p>
                             <p>感谢，<br />{app_name}</p>',
                    'pt-br' => '<p>Olá,&nbsp;<br />Bem-vindo ao {app_name}.</p>
                                <p>{ticket_name}</p>
                                <p>{ticket_id}</p>
                                <p><strong>Descrição</strong> : {ticket_description}</p>
                                <p>Obrigado,<br />{app_name}</p>',


                ],
            ],

        ];

        $email = EmailTemplate::all();

        foreach ($email as $e) {
            foreach ($defaultTemplate[$e->name]['lang'] as $lang => $content) {
                EmailTemplateLang::create(
                    [
                        'parent_id' => $e->id,
                        'lang' => $lang,
                        'subject' => $defaultTemplate[$e->name]['subject'],
                        'content' => $content,
                    ]
                );
            }
        }
    }


    public static function send_slack_msg($slug,$obj,$user_id=null)
    {
        $notification_template = NotificationTemplates::where('slug',$slug)->first();

        if (!empty($notification_template) && !empty($obj))
        {
            if(!empty($user_id))
            {

                $user = User::find($user_id);
            }
            else
            {
                $user = \Auth::user();

            }
            $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->where('created_by', '=', $user->id)->first();
            // $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang ?? 'en')->where('created_by', '=', $user->id ?? 1)->first();

            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->first();
            }
            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang       = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', 'en')->first();
            }
            if (!empty($curr_noti_tempLang) && !empty($curr_noti_tempLang->content))
            {
                $msg = self::replaceVariable($curr_noti_tempLang->content, $obj);
            }
        }
        if (isset($msg))
        {
            $settings =  Utility::settings($user->id);

            try {
                if (isset($settings['slack_webhook']) && !empty($settings['slack_webhook'])) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $settings['slack_webhook']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $msg]));
                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                }
            } catch (\Exception $e) {
            }
        }

    }

    public static function getCookieSetting()
    {
        $data = DB::table('settings')->where('created_by', '=', 1)->get();
        $cookie_settings = [
            "enable_cookie" => "on",
            "default_language" => "en",
            "cookie_title" => "We use cookies!",
            "cookie_description" => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it.',
            "strictly_cookie_title" => "Strictly necessary cookies",
            "strictly_cookie_description" => "These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly",
            "contact_description" => "For any queries in relation to our policy on cookies and your choices,",
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,please',
            "contactus_url" => '<a class="cc-link" href="#yourcontactpage">contact us</a>.',
        ];
        foreach ($data as $row) {
            if (array_key_exists($row->name, $cookie_settings)) {
                $cookie_settings[$row->name] = $row->value;
            }
        }
        return $cookie_settings;
    }

    public static function send_telegram_msg($slug,$obj,$user_id=null)
    {
        $notification_template = NotificationTemplates::where('slug',$slug)->first();

        if (!empty($notification_template) && !empty($obj))
        {
            if(!empty($user_id))
            {
                $user = User::find($user_id);
            }
            else
            {
                $user = \Auth::user();
            }
            $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->where('created_by', '=', $user->id)->first();

            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->first();
            }
            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang       = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', 'en')->first();
            }
            if (!empty($curr_noti_tempLang) && !empty($curr_noti_tempLang->content))
            {
                $msg = self::replaceVariable($curr_noti_tempLang->content, $obj);
            }
        }


        if (isset($msg))
        {
            $settings =  Utility::settings($user->id);

            try{
                // Set your Bot ID and Chat ID.
                $telegrambot    = $settings['telegram_accestoken'];
                $telegramchatid = $settings['telegram_chatid'];
                // Function call with your own text or variable
                $url     = 'https://api.telegram.org/bot' . $telegrambot . '/sendMessage';
                $data    = array(
                    'chat_id' => $telegramchatid,
                    'text' => $msg,
                );
                $options = array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query($data),
                    ),
                );
                dd($msg);
                $context = stream_context_create($options);
                $result  = file_get_contents($url, false, $context);
                $url     = $url;
            }
            catch(\Exception $e){
            }
        }

    }

    public static function userDefaultData()
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();

        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 1,
                    'is_active' => 1,
                ]
            );
        }
    }

    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {

        if(\Auth::check()){

            $usr = \Auth::user();
            //Remove Current Login user Email don't send mail to them
            unset($mailTo[$usr->id]);
            $mailTo = array_values($mailTo);
            if($usr->type != 'Super Admin')
            {
                // find template is exist or not in our record
                $template = EmailTemplate::where('slug', $emailTemplate)->first();


                if(isset($template) && !empty($template))
                {
                    // check template is active or not by company
                    $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->id)->first();


                    if(isset($is_active)  && $is_active->is_active == 1)
                    {
                        $settings = self::settings();
                        // get email content language base
                        $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                        $content->from = $template->from;

                        if(!empty($content->content))
                        {

                            $content->content = self::replaceVariable($content->content, $obj);



                            // send email
                            try
                            {
                                // dd($mailTo,$content,$settings);
                                Mail::to($mailTo)->send(new CommonEmailTemplate($content,$settings));

                            }
                            catch(\Exception $e)
                            {
                                $error = __('E-Mail has been not sent due to SMTP configuration');
                            }

                            if(isset($error))
                            {
                                $arReturn = [
                                    'is_success' => false,
                                    'error' => $error,
                                ];
                            }
                            else
                            {
                                $arReturn = [
                                    'is_success' => true,
                                    'error' => false,
                                ];
                            }
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => __('Mail not send, email is empty'),
                            ];
                        }

                        return $arReturn;
                    }
                    else
                    {
                        return [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                }
                else
                {
                    return [
                        'is_success' => false,
                        'error' => __('Mail not send, email not found'),
                    ];
                }
            }
        }
        else{


            $template = EmailTemplate::where('slug', $emailTemplate)->first();

            if(isset($template) && !empty($template))
            {
                // check template is active or not by company
                $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', 1)->first();


                if(isset($is_active)  && $is_active->is_active == 1)
                {
                    $settings = self::settings();

                    $usr = User::find(1);
                    // get email content language base
                    $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                    $content->from = $template->from;

                    if(!empty($content->content))
                    {

                        $content->content = self::replaceVariable($content->content, $obj);

                        // send email
                        try
                        {

                            Mail::to($mailTo)->send(new CommonEmailTemplate($content,$settings));

                        }
                        catch(\Exception $e)
                        {
                            $error = __('E-Mail has been not sent due to SMTP configuration');
                        }

                        if(isset($error))
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => $error,
                            ];
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => true,
                                'error' => false,
                            ];
                        }
                    }
                    else
                    {
                        $arReturn = [
                            'is_success' => false,
                            'error' => __('Mail not send, email is empty'),
                        ];
                    }

                    return $arReturn;
                }
                else
                {
                    return [
                        'is_success' => true,
                        'error' => false,
                    ];
                }
            }
            else
            {
                return [
                    'is_success' => false,
                    'error' => __('Mail not send, email not found'),
                ];
            }

        }
    }

    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{app_name}' ,
            '{company_name}',
            '{ticket_name}' ,
            '{ticket_id}' ,
            '{ticket_description}',
            '{app_url}' ,
            '{email}' ,
            '{password}' ,
            '{user_name}',
        ];

        $arrValue    = [
            'app_name' => '-',
            'company_name' => '-',
            'ticket_name' => '-',
            'ticket_id' => '-',
            'ticket_description' => '-',
            'app_url' => '-',
            'email' => '-',
            'password' => '-',
            'user_name' => '-',
        ];

        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }

        $settings = Utility::settings();
        $company_name = $settings['company_name'];

        $arrValue['app_name']     =  $company_name;
        $arrValue['company_name'] = self::settings()['company_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }

    public static function languages()
    {
        $languages=Utility::langList();

          if(\Schema::hasTable('languages')){
        $settings = Utility::langSetting();
        if(!empty($settings['disable_lang'])){
            $disabledlang =explode(',', $settings['disable_lang']);
            $languages = Languages::whereNotIn('code',$disabledlang)->pluck('fullName','code');
        }
        else{
            $languages = Languages::pluck('fullName','code');
        }
        }

         return $languages;
    }

    public static function languagecreate(){
        $languages=Utility::langList();
        foreach($languages as $key => $lang)
        {
            $languageExist = Languages::where('code',$key)->first();
            if(empty($languageExist))
            {
                $language = new Languages();
                $language->code = $key;
                $language->fullName = $lang;
                $language->save();
            }
        }
    }

    public static function langList(){
        $languages = [
            "ar" => "Arabic",
            "zh" => "Chinese",
            "da" => "Danish",
            "de" => "German",
            "en" => "English",
            "es" => "Spanish",
            "fr" => "French",
            "he" => "Hebrew",
            "it" => "Italian",
            "ja" => "Japanese",
            "nl" => "Dutch",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "ru" => "Russian",
            "tr" => "Turkish",
            "pt-br" => "Portuguese(Brazil)",
        ];
        return $languages;
    }

    public static function langSetting(){
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1)->get();
        if (count($data) == 0) {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $settings= [];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function updateUserDefaultEmailTempData()
    {
        $UserEmailTemp = UserEmailTemplate::groupBy('user_id')->pluck('user_id');
        $allUser = User::where('name','Admin')->whereNotIn('id',$UserEmailTemp)->get();

        foreach ($allUser as $user) {

            $allEmail = EmailTemplate::all();

            foreach ($allEmail as $email) {
                UserEmailTemplate::create(
                    [
                        'template_id' => $email->id,
                        'user_id' => $user->id,
                        'is_active' => 1,
                    ]
                );
            }
        }
    }

    public static function upload_file($request,$key_name,$name,$path,$custom_validation =[]){
        try{
            $settings = Utility::settings();
            if(!empty($settings['storage_setting'])){

                if($settings['storage_setting'] == 'wasabi'){

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';


                }else{
                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'2048';

                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }


                $file = $request->$key_name;


                if(count($custom_validation) > 0){
                    $validation =$custom_validation;
                }else{

                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];

                }
                $validator = \Validator::make($request->all(), [
                    $key_name =>$validation
                ]);

                if($validator->fails()){
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if($settings['storage_setting']=='local')
                    {
                        $request->$key_name->move(storage_path($path), $name);
                        $path = $path.$name;

                    }else if($settings['storage_setting'] == 'wasabi'){

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );


                        // $path = $path.$name;

                    }else if($settings['storage_setting'] == 's3'){

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                        // $path = $path.$name;
                        // dd($path);
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  =>'success',
                        'url'  => $path
                    ];
                    return $res;
                }

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function get_file($path){
        $settings = Utility::settings();

        try {
            if($settings['storage_setting'] == 'wasabi'){

                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                    ]
                );

            }elseif($settings['storage_setting'] == 's3'){
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }

            return \Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
            return '';
        }
    }

    public static function getStorageSetting()
    {

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();
        $settings = [
            "storage_setting" => "",
            "local_storage_validation" => "",
            "local_storage_max_upload_size" => "",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function multipalFileUpload($request,$key_name,$name,$path,$data_key,$custom_validation =[])
    {
        $multifile = [
            $key_name => $request->file($key_name)[$data_key],
        ];


        try{
            $settings = Utility::settings();

            if(!empty($settings['storage_setting'])){

                if($settings['storage_setting'] == 'wasabi'){

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';


                }else{
                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'2048';

                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }


                $file = $request->$key_name;


                if(count($custom_validation) > 0){
                    $validation =$custom_validation;
                }else{

                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];

                }
                $validator = \Validator::make($multifile, [
                    $key_name =>$validation
                ]);

                if($validator->fails()){
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {
                    $name = $name;
                    if($settings['storage_setting']=='local'){
                        \Storage::disk()->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );

                        $path = $name;
                    }else if($settings['storage_setting'] == 'wasabi'){

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    }else if($settings['storage_setting'] == 's3'){

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                    }

                    $res = [
                        'flag' => 1,
                        'msg'  =>'success',
                        'url'  => $path
                    ];
                    return $res;
                }

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function addCustomeField($user_id){
        $data = [
            [
                'name'=>'Name',
                'type'=> 'text',
                'placeholder'=> 'Name',
                'width'=> '6',
                'order'=> '0',
                'status'=> '0',
                'is_required'=> '1',
            ],
            [
                'name'=>'Email',
                'type'=> 'email',
                'placeholder'=> 'Email',
                'width'=> '6',
                'order'=> '1',
                'status'=> '0',
                'is_required'=> '1',

            ],
            [
                'name'=>'Category',
                'type'=> 'select',
                'placeholder'=> 'Select Category',
                'width'=> '6',
                'order'=> '2',
                'status'=> '0',
                'is_required'=> '1',

            ],
            [
                'name'=>'Subject',
                'type'=> 'text',
                'placeholder'=> 'Subject',
                'width'=> '6',
                'order'=> '3',
                'status'=> '0',
                'is_required'=> '1',

            ],
            [
                'name'=>'Description',
                'type'=> 'textarea',
                'placeholder'=> 'Description',
                'width'=> '12',
                'order'=> '4',
                'status'=> '0',
                'is_required'=> '1',

            ],
            [
                'name'=>'Attachments',
                'type'=> 'file',
                'placeholder'=> 'You can select multiple files',
                'width'=> '12',
                'order'=> '5',
                'status'=> '0',
                'is_required'=> '1',

            ],
            [
                'name'=>'Priority',
                'type'=> 'select',
                'placeholder'=> 'Select Priority',
                'width'=> '6',
                'order'=> '6',
                'status'=> '0',
                'is_required'=> '1',

            ],

        ];

        $insert = DB::table('custom_fields')->insert($data);
    }

    public static function GetCacheSize()
    {
        $file_size = 0;
        foreach (\File::allFiles(storage_path('/framework')) as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);
        return $file_size;
    }


    public static function flagOfCountry(){
        $arr = [
            'ar' => '🇦🇪 ar',
            'da' => '🇩🇰 da',
            'de' => '🇩🇪 de',
            'es' => '🇪🇸 es',
            'fr' => '🇫🇷 fr',
            'it' => '🇮🇹 it',
            'ja' => '🇯🇵 ja',
            'nl' => '🇳🇱 nl',
            'pl' => '🇵🇱 pl',
            'ru' => '🇷🇺 ru',
            'pt' => '🇵🇹 pt',
            'en' => '🇮🇳 en',
            'tr' => '🇹🇷 tr',
            'pt-br' => '🇵🇹 pt-br',
            'zh' => '🇨🇳 zh',
            'he' => '🇮🇱 he',

        ];
        return $arr;
    }

    public static function getSeoSetting()
    {
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        // @dd($data);
        $data     = $data->get();
        $settings = [
            "meta_keywords" => "",
            "meta_image" => "",
            "meta_description" => ""
        ];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }



    public static function webhookSetting($module, $user_id = null)
    {
        if (!empty($user_id)) {
            $user = User::find($user_id);
        } else {
            $user = \Auth::user();
        }
        $webhook = Webhook::where('module', $module)->where('created_by', '=', $user->id)->first();
        if (!empty($webhook)) {
            $url = $webhook->url;
            $method = $webhook->method;
            $reference_url  = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $data['method'] = $method;
            $data['reference_url'] = $reference_url;
            $data['url'] = $url;
            return $data;
        }
        return false;
    }

    public static function WebhookCall($url = null, $parameter = null, $method = 'POST')
    {
        if (!empty($url) && !empty($parameter)) {
            try {
                $curlHandle = curl_init($url);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameter);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                $curlResponse = curl_exec($curlHandle);
                curl_close($curlHandle);
                if (empty($curlResponse)) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }
}
