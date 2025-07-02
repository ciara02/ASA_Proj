<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LDAPEngineer extends Model
{

    public $fullName;
    public $email;
    public $samAccountName;

    /**
     * LDAPUser constructor.
     *
     * @param string $fullName
     * @param string $email
     * @param string $samAccountName
     */
    public function __construct($fullName = null, $email = null, $samAccountName = null)
    {
        parent::__construct();

        $this->fullName = $fullName;
        $this->email = $email;
        $this->samAccountName = $samAccountName;
    }

    /**
     * Fetch LDAP data and create LDAPUser instances.
     *
     * @return array An array of LDAPUser instances.
     */
    public static function fetchFromLDAP()
    {
        $ldapServer = '10.105.33.31';
        $ldapPort = 389;
        $ldapUsername = 'MSI\Administrator';
        $ldapPassword = 'msidcm@DMIN2019';
        $ldapBaseDn = 'dc=msi,dc=com';

        $ldapConn = ldap_connect($ldapServer, $ldapPort);
        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

        ldap_bind($ldapConn, $ldapUsername, $ldapPassword);

        $searchFilter = '(&(objectClass=person)(objectCategory=Person)(sAMAccountName=*)(memberOf=CN=ASA System Engineers,CN=Users,DC=msi,DC=com))';

        $searchResults = ldap_search($ldapConn, $ldapBaseDn, $searchFilter);
        $entries = ldap_get_entries($ldapConn, $searchResults);

        ldap_close($ldapConn);

        $ldapUsers = [];
        foreach ($entries as $entry) {
            if (!empty($entry['samaccountname'][0])) {
                $email = !empty($entry['mail'][0]) ? strtolower(trim($entry['mail'][0])) : '';
                $sn = !empty($entry['sn'][0]) ? trim($entry['sn'][0]) : '';
                $givenName = !empty($entry['givenname'][0]) ? trim($entry['givenname'][0]) : '';

                $fullName = $givenName . ' ' . $sn;
                $samAccountName = $entry['samaccountname'][0];

                $ldapUsers[] = new self($fullName, $email, $samAccountName);
            }
        }

        return $ldapUsers;
    }

    public static function fetchUserFromLDAP($username)
    {
        $ldapServer = '10.105.33.31';
        $ldapPort = 389;
        $ldapUsername = 'MSI\Administrator';
        $ldapPassword = 'msidcm@DMIN2019';
        $ldapBaseDn = 'dc=msi,dc=com';
    
        $ldapConn = ldap_connect($ldapServer, $ldapPort);
        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
    
        ldap_bind($ldapConn, $ldapUsername, $ldapPassword);
    
        $searchFilter = "(&(objectClass=person)(objectCategory=Person)(sAMAccountName=$username))";
    
        $searchResults = ldap_search($ldapConn, $ldapBaseDn, $searchFilter);
        $entries = ldap_get_entries($ldapConn, $searchResults);
    
        ldap_close($ldapConn);
    
        if (isset($entries[0])) {
            $entry = $entries[0];
            $email = !empty($entry['mail'][0]) ? strtolower(trim($entry['mail'][0])) : '';
            $sn = !empty($entry['sn'][0]) ? trim($entry['sn'][0]) : '';
            $givenName = !empty($entry['givenname'][0]) ? trim($entry['givenname'][0]) : '';
    
            $fullName = $givenName . ' ' . $sn;
            $samAccountName = $entry['samaccountname'][0];
    
            return new self($fullName, $email, $samAccountName);
        }
    
        return null;  // Return null if no users found
    }
     
    public static function tagEngineer($filter)
    {
        $ldapServer = '10.105.33.31';
        $ldapPort = 389;
        $ldapUsername = 'MSI\Administrator';
        $ldapPassword = 'msidcm@DMIN2019';
        $ldapBaseDn = 'dc=msi,dc=com';
    
        $ldapConn = ldap_connect($ldapServer, $ldapPort);
        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
    
        ldap_bind($ldapConn, $ldapUsername, $ldapPassword);
    
        $searchResults = ldap_search($ldapConn, $ldapBaseDn, $filter);
        $entries = ldap_get_entries($ldapConn, $searchResults);
    
        ldap_close($ldapConn);
    
        $ldapUsers = [];
        foreach ($entries as $entry) {
            if (!empty($entry['samaccountname'][0])) {
                $email = !empty($entry['mail'][0]) ? strtolower(trim($entry['mail'][0])) : '';
                $sn = !empty($entry['sn'][0]) ? trim($entry['sn'][0]) : '';
                $givenName = !empty($entry['givenname'][0]) ? trim($entry['givenname'][0]) : '';
    
                $fullName = $givenName . ' ' . $sn;
                $samAccountName = $entry['samaccountname'][0];
    
                // Ensure LDAPEngineer constructor is correctly accepting parameters
                $ldapUsers[] = new self($fullName, $email, $samAccountName);
            }
        }
    
        return $ldapUsers;
    }
    

    public static function SupervisorLDAP()
    {
        $ldapServer = '10.105.33.31';
        $ldapPort = 389;
        $ldapUsername = 'MSI\Administrator';
        $ldapPassword = 'msidcm@DMIN2019';
        $ldapBaseDn = 'dc=msi,dc=com';

        $ldapConn = ldap_connect($ldapServer, $ldapPort);
        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

        ldap_bind($ldapConn, $ldapUsername, $ldapPassword);

        // $searchFilter = '(&(objectClass=person)(objectCategory=Person)(sAMAccountName=*)(memberOf=CN=ASA System Engineers,CN=Users,DC=msi,DC=com))';
        $searchFilter = '(&(objectCategory=Person)(sAMAccountName=*)(memberOf=CN=ASA System Leaders,CN=Users,DC=msi,DC=com))';

        $searchResults = ldap_search($ldapConn, $ldapBaseDn, $searchFilter);
        $entries = ldap_get_entries($ldapConn, $searchResults);

        ldap_close($ldapConn);

        $ldapUsers = [];
        foreach ($entries as $entry) {
            if (!empty($entry['samaccountname'][0])) {
                $email = !empty($entry['mail'][0]) ? strtolower(trim($entry['mail'][0])) : '';
                $sn = !empty($entry['sn'][0]) ? trim($entry['sn'][0]) : '';
                $givenName = !empty($entry['givenname'][0]) ? trim($entry['givenname'][0]) : '';

                $fullName = $givenName . ' ' . $sn;
                $samAccountName = $entry['samaccountname'][0];

                $ldapUsers[] = new self($fullName, $email, $samAccountName);
            }
        }

        return $ldapUsers;
    }

    public static function searchByEmail($email)
    {
        $transformedEmail = self::transformEmailToLDAP($email);
    
        $filter = sprintf('(mail=%s)', $transformedEmail);
        $results = self::tagEngineer($filter);
    
        return $results ?? [];
    }
    
    private function transformEmailToLDAP($email)
    {
        // Validate email format before transformation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email; // Return as-is if not valid
        }
    
        $parts = explode('@', $email);
    
        // Apply transformation: keep first letter before the underscore and then keep the surname
        $username = preg_replace_callback('/^([a-zA-Z])([^_]+)_([^@]+)$/', function ($matches) {
            // $matches[1] is the first letter, $matches[2] is the part before the underscore, $matches[3] is the surname
            return $matches[1] . $matches[3]; // Combine first letter with surname
        }, $parts[0]);
    
        $domain = $parts[1];
    
        return $username . '@' . $domain;
    }
    

}


