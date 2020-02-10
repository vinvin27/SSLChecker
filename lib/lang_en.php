<?php
function lang($phrase){
    static $lang = array(
    	#
    	#  STATUS MONITOR
    	#
        'URL_HIDDEN' => 'URL Hidden',
        'STATUS_VALID' => 'Valid',
        'STATUS_POLLING' => 'Polling',
        'STATUS_RENEW' => 'Renewable',
        'STATUS_RENEW2' => 'Renewable',
        'STATUS_A_EXPIRED' => 'Almost Expired',
        'STATUS_EXPIRED' => 'Expired',
        'STATUS_ERROR' => 'Error',
        'STATUS_DOMAIN' => 'Domain',
        'STATUS_AUTH' => 'Authority',
        'STATUS_PERIOD' => 'Period',
        'STATUS_EXPERY' => 'Expiry in',
        'STATUS_STATE' => 'State',
        'STATUS_DAYS' => 'Days',
        'STATUS_MONITOR' => 'Monitor',
        'STATUS_ADMIN_DELETE' => 'Delete server',
        'STATUS_ADMIN_DELETE_MSG' => 'Are you sure you want to delete this entry from the database?',
        'STATUS_ADMIN_HISTORY' => 'Show history',
        'STATUS_ADMIN_OPTIONS' => 'Options',
        #
        #  LOGIN FORM
        #
        'LOGIN_CAPTCHA_ERROR' => 'Please complete the recaptcha',
        'LOGIN_AUTH_ERROR' => 'Username or password is incorrect',
        'LOGIN_TITLE' => 'SSLChecker is the best SSL checker available online.',
        'LOGIN_TITLE_TEXT' => 'Use this system to monitor all of your SSL certificates from any authority.',
        'LOGIN_USERNAME' => 'Username',
        'LOGIN_PASSWORD' => 'Password',
        'LOGIN_LOGIN' => 'Login',
        'LOGIN_SIGNIN_TEXT' => 'Sign into your account',
        'LOGIN_SIGNUP' => 'Sign up',
        'LOGIN_SIGNUP_TEXT' => 'Dont have a account?',
        #
        #  CERT HISTORY
        #
        'CERT_DOMAIN' => 'Domain',
        'CERT_PORT' => 'Port',
        'CERT_AUTH' => 'Authority',
        'CERT_VFROM' => 'Valid from',
        'CERT_VTO' => 'Valid to',
        'CERT_STATE' => 'State',
        'CERT_CHANGED' => 'Changed on',
        'CERT_USED_TITLE' => 'Used old certificates',
        'CERT_HISTORY_TITLE' => 'Cerificate history',
        'CERT_INFO' => 'SSL Info',
        #
        #  HEADER UI
        #
        'MENU_DASH' => 'Dashboard',
        'MENU_INFO' => 'Information',
        'MENU_ADMIN' => 'Admin Area',
        'MENU_ADMIN_ADD' => 'Add server',
        'MENU_ADMIN_PUSH' => 'Pushbullet',
        'MENU_ADMIN_UPDATE' => 'Update data',
        'MENU_LOGIN' => 'Login',
        'MENU_LOGOUT' => 'Logout',
        'MENU_LOGIN_MYACCOUNT' => 'My account',
        'PAGE_DESC' => 'The SSL Monitor for all your websites.',
        'PAGE_BRAND' => 'PepperSSL',


        'last' => 'Error'

    );
    return $lang[$phrase];
}
?>