<?php

namespace Btw\Core\Entities;

use Btw\Core\Traits\HasMeta;
use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    use HasMeta;

      /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier(){
        return $this->attributes['id'] ?? null; 
    }

     /**
     * Renders Datatable Url
     *
     * @return string
     */
    public function getUrlEditAdmin(){
       return route_to('user-only-information', $this->attributes['id']);
    }

     /**
     * Renders Datatable Username Initial
     *
     * @return string
     */
    public function getNameInitial(){

        $lastName = $this->attributes['last_name'][0] ?? false;
        $firstName = $this->attributes['first_name'][0] ?? false;
        return $lastName . ' ' .$firstName; 

    }

    /**
     * Renders out the user's avatar at the specified size (in pixels)
     *
     * @return string
     */
    public function renderAvatar(int $size = 52, $class = 'img-fluid') 
    {
        // Determine the color for the user based on their
        // email address since we know we'll always have that
        // Use default hash if the avatar is used as a placeholder
        if (setting('Users.avatarNameBasis') === 'name') {
            $idString = !empty($this->first_name)
                ? ($this->first_name[0]) . ($this->last_name[0] ?? '')
                : $this->username[0]
                ?? $this->email[0]
                ?? 'default-avatar-hash';
        } else {
            $idString = !empty($this->username)
                ? $this->username[0] . $this->username[1]
                : ($this->first_name[0]) . ($this->last_name[0] ?? '')  // @phpstan-ignore-line
                ?? $this->email[0]
                ?? 'default-avatar-hash';
        }

        $idString = strtoupper($idString);

        $idValue = str_split($idString);
        array_walk($idValue, static function (&$char) {
            $char = ord($char);
        });
        $idValue = implode('', $idValue);

        $colors = setting('Users.avatarPalette');

        return view('\Btw\Core\Views\_avatar', [
            'user'       => $this,
            'class'      => $class,
            'size'       => $size,
            'fontSize'   => 20 * ($size / 52),
            'idString'   => $idString,
            'background' => !empty($colors) ? $colors[$idValue % count($colors)] : '#FFFFFF',
        ]);
    }

    /**
     * Generates a link to the user Avatar
     */
    public function avatarLink(?int $size = null): string
    {
        $contentAvatar = ['googleusercontent'];
        if (empty($this->avatar)) {
            // Default from Gravatar
            if (setting('Users.useGravatar')) {
                $hash = md5(strtolower(trim($this->email)));

                return "https://www.gravatar.com/avatar/{$hash}?" . http_build_query([
                    's' => ($size ?? 60),
                    'd' => setting(
                        'Users.gravatarDefault'
                    ),
                ]);
            }
        }
        // Oauth
        if(strpos($this->avatar, 'https') !== false){
            return $this->avatar;
        }

        return !empty($this->avatar)
            ? base_url('/uploads/avatars/' . $this->avatar)
            : '';
    }

    /**
     * Returns the full name of the user.
     */
    public function name(): string
    {
        return trim(implode(' ', [$this->first_name, $this->last_name]));
    }

    /**
     * @return string
     */
    public function adminLink(?string $postfix = null)
    {
        $url = ADMIN_AREA . "/users/{$this->id}";

        if (!empty($postfix)) {
            $url .= "/{$postfix}";
        }

        return trim(site_url($url));
    }

    /**
     * Returns a list of the groups the user is involved in.
     */
    public function groupsList(): string
    {
        $config = setting('AuthGroups.groups');
        $groups = $this->getGroups();

        $out = [];

        foreach ($groups as $group) {
            $out[] = $config[$group]['title'];
        }

        return implode(', ', $out);
    }

    /**
     * Returns the validation rules for all User meta fields, if any.
     */
    public function validationRules(?string $prefix = null): array
    {
        return $this->metaValidationRules('Users', $prefix);
    }
}
