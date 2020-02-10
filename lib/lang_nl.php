<?php
function lang($phrase){
    static $lang = array(
    	#
    	#  STATUS MONITOR
    	#
        'URL_HIDDEN' => 'URL Verborgen',
        'STATUS_VALID' => 'Geldig',
        'STATUS_POLLING' => 'Aan het laden',
        'STATUS_RENEW' => 'Vernieuwbaar',
        'STATUS_RENEW2' => 'Vernieuwbaar',
        'STATUS_A_EXPIRED' => 'Bijna verlopen',
        'STATUS_EXPIRED' => 'Verlopen',
        'STATUS_ERROR' => 'Fouten',
        'STATUS_DOMAIN' => 'Domein',
        'STATUS_AUTH' => 'Autoriteit',
        'STATUS_PERIOD' => 'Periode',
        'STATUS_EXPERY' => 'Verlopen in',
        'STATUS_STATE' => 'Staat',
        'STATUS_DAYS' => 'Dagen',
        'STATUS_MONITOR' => 'Monitor',
        'STATUS_ADMIN_DELETE' => 'Verwijder server',
        'STATUS_ADMIN_DELETE_MSG' => 'Weet je zeker dat je de server wilt verwijderen?',
        'STATUS_ADMIN_HISTORY' => 'Geschiedenis',
        'STATUS_ADMIN_OPTIONS' => 'Opties',
        #
        #  LOGIN FORM
        #
        'LOGIN_CAPTCHA_ERROR' => 'Voltooi de captcha',
        'LOGIN_AUTH_ERROR' => 'Gebruikersnaam of wachtwoord is incorrect',
        'LOGIN_TITLE' => 'SSLChecker is de beste SSLChecker online.',
        'LOGIN_TITLE_TEXT' => 'Gebruik dit systeem om je SSL cerificaten te monitoren en te beheren.',
        'LOGIN_USERNAME' => 'Gebruikersnaam',
        'LOGIN_PASSWORD' => 'Wachtwoord',
        'LOGIN_LOGIN' => 'Inloggen',
        'LOGIN_SIGNIN_TEXT' => 'Inloggen in je account',
        'LOGIN_SIGNUP' => 'Aanmelden',
        'LOGIN_SIGNUP_TEXT' => 'Nog geen account?',
        #
        #  CERT HISTORY
        #
        'CERT_DOMAIN' => 'Domein',
        'CERT_PORT' => 'Poort',
        'CERT_AUTH' => 'Autoriteit',
        'CERT_VFROM' => 'Geldig van',
        'CERT_VTO' => 'Geldig tot',
        'CERT_STATE' => 'Staat',
        'CERT_CHANGED' => 'Veranderd op',
        'CERT_USED_TITLE' => 'Gebruikte certificaten',
        'CERT_HISTORY_TITLE' => 'Certificaten geschiedenis',
        'CERT_INFO' => 'SSL Informatie',
        #
        #  HEADER UI
        #
        'MENU_DASH' => 'Overzicht',
        'MENU_INFO' => 'Informatie',
        'MENU_ADMIN' => 'Admin Tools',
        'MENU_ADMIN_ADD' => 'Server toevoegen',
        'MENU_ADMIN_PUSH' => 'Pushbullet',
        'MENU_ADMIN_UPDATE' => 'Vernieuw data',
        'MENU_LOGIN' => 'Inloggen',
        'MENU_LOGOUT' => 'Uitloggen',
        'MENU_LOGIN_MYACCOUNT' => 'Mijn account',
        'PAGE_DESC' => 'De SSL monitor voor al jouw websites.',
        'PAGE_BRAND' => 'PepperSSL',


        'last' => 'Error'

    );
    return $lang[$phrase];
}
?>