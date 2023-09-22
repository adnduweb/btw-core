<?php

namespace Btw\Core\Models;

use Btw\Core\Entities\User;
use CodeIgniter\Shield\Models\UserModel as ShieldUsers;
use Faker\Generator;
use Btw\Core\Traits\ActivitiesTrait;

/**
 * This User model is ready for your customization.
 * It extends Shield's UserModel, providing many auth
 * features built right in.
 */
class UserModel extends ShieldUsers
{

    use ActivitiesTrait;

    protected $useTimestamps = true;
    protected $afterFind     = ['fetchIdentities'];
    protected $afterInsert   = ['saveEmailIdentity', 'activityInsert'];
    protected $afterUpdate   = ['saveEmailIdentity', 'activityUpdate'];
    protected $afterDelete = ['activityDelete'];


    protected $returnType    = User::class;
    protected $allowedFields = [
        'company_id', 'username', 'status', 'status_message', 'active', 'last_active', 'deleted_at',
        'avatar', 'main_account', 'photo_profile', 'first_name', 'last_name', 'email_verified_at'
    ];


    protected $columns = [
        ['name' => 'selection'],
        ['name' => 'username', 'orderable' => true, 'header' => 'Username', 'order_by_username' => 'DESC', 'responsivePriority' => 1],
        ['name' => 'secret', 'orderable' => true, 'header' => 'Email', 'order_by_email' => 'DESC'],
        ['name' => 'active', 'orderable' => true, 'header' => 'Active', 'order_by_active' => 'DESC', 'notClick' => true],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'created_at', 'order_by_email' => 'DESC'],
        ['name' => 'last_active', 'orderable' => true, 'header' => 'last_active', 'order_by_email' => 'DESC'],
        ['name' => 'type', 'orderable' => true, 'header' => 'Type', 'order_by_type' => 'DESC'],
        ['name' => 'status', 'orderable' => true, 'header' => 'Statut', 'order_by_statut' => 'DESC'],
        ['name' => '2fa', 'orderable' => true, 'header' => '2FA', 'order_by_2fa' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => NULL,  'responsivePriority' => 2]

    ];

    const ORDERABLE = [
        1 => 'last_name',
        2 => 'first_name',
        3 => 'email',
        4 => 'created_at',
    ];

    public static $orderable = ['last_name', 'first_name', 'email', 'created_at'];

    public function getColumn()
    {
        return $this->columns;
    }

    /**
     * Performs additional setup when finding objects
     * for the recycler. This might pull in additional
     * fields.
     */
    public function setupRecycler()
    {
        $dbPrefix = $this->db->getPrefix();

        return $this->select("{$dbPrefix}users.*,
            (SELECT secret
                from {$dbPrefix}auth_identities
                where user_id = {$dbPrefix}users.id
                    and type = 'email_password'
                order by last_used_at desc
                limit 1
            ) as email
        ");
    }

    public function fake(Generator &$faker): User
    {
        return new User([
            'username'   => $faker->userName(),
            'first_name' => $faker->firstName(),
            'last_name'  => $faker->lastName(),
            'active'     => true,
        ]);
    }


    /**
     * Returns the groups user.
     */
    public function getAuthGroupsUsers(int $id): array
    {
        $builder =  $this->db->table('auth_groups_users')
            ->select('group')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()->getResultArray();

        $returnGroup = [];
        if (!empty($builder)) {
            foreach ($builder as $gp) {
                $returnGroup[] = $gp['group'];
            }
        }
        return $returnGroup;
    }
}
