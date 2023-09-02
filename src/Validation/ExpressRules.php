<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Validation;

class ExpressRules{

    // Rule is to validate mobile number digits
    public function mobileValidation(string $str, string $fields, array $data){
        
        if(isset($data['phone_mobile']) && !empty($data['phone_mobile'])){
           
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $swissNumberProto = $phoneUtil->parse($data['phone_mobile'],  $data['country']);
                if (!$phoneUtil->isValidNumber($swissNumberProto)) {
                    return false;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
        }

        if(isset($data['contact']['phone_mobile']) && !empty($data['contact']['phone_mobile'])){

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $swissNumberProto = $phoneUtil->parse($data['contact']['phone_mobile'],  $data['contact']['country']);
                if (!$phoneUtil->isValidNumber($swissNumberProto)) {
                    return false;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
        }
    }

      // Rule is to validate mobile number digits
      public function phoneValidation(string $str, string $fields, array $data){

       // print_r($data); exit;
        
        if(isset($data['phone']) && !empty($data['phone'])){

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $swissNumberProto = $phoneUtil->parse($data['phone'],  $data['country']);
                if (!$phoneUtil->isValidNumber($swissNumberProto)) {
                    return false;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
        }

        if(isset($data['address']['phone']) && !empty($data['address']['phone'])){

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $swissNumberProto = $phoneUtil->parse($data['address']['phone'],  $data['address']['country']);
                if (!$phoneUtil->isValidNumber($swissNumberProto)) {
                    return false;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
        }

        if(isset($data['contact']['phone']) && !empty($data['contact']['phone'])){

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $swissNumberProto = $phoneUtil->parse($data['contact']['phone'],  $data['contact']['country']);
                if (!$phoneUtil->isValidNumber($swissNumberProto)) {
                    return false;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                return false;
            }
        }

    }

      // fonction permettant de contrôler la validité d'un numéro SIRET
      public function is_siret(string $str, string $fields, array $data){

            if (strlen($data['siret']) != 14) return false; // le SIRET doit contenir 14 caractères
            if (!is_numeric($data['siret'])) return false; // le SIRET ne doit contenir que des chiffres
    
            // on prend chaque chiffre un par un
            // si son index (position dans la chaîne en commence à 0 au premier caractère) est pair
            // on double sa valeur et si cette dernière est supérieure à 9, on lui retranche 9
            // on ajoute cette valeur à la somme totale
            $sum = 0;
            for ($index = 0; $index < 14; $index ++)
            {
                $number = (int) $data['siret'][$index];
                if (($index % 2) == 0) { if (($number *= 2) > 9) $number -= 9; }
                $sum += $number;
            }
    
            // le numéro est valide si la somme des chiffres est multiple de 10
            if (($sum % 10) != 0) 
                return 3; 
            else 
                return 0;		
      }

}

