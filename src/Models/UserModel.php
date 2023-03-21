<?php

namespace Btw\Core\Models;

use Btw\Core\Entities\User;
use CodeIgniter\Shield\Models\UserModel as ShieldUsers;
use Faker\Generator;

/**
 * This User model is ready for your customization.
 * It extends Shield's UserModel, providing many auth
 * features built right in.
 */
class UserModel extends ShieldUsers
{
    protected $returnType    = User::class;
    protected $allowedFields = [
        'username', 'status', 'status_message', 'active', 'last_active', 'deleted_at',
        'avatar', 'first_name', 'last_name', 'email_verified_at'
    ];


    protected $columns = [
        ['name' => 'selection'],
        // ['name' => 'id', 'orderable' => true, 'header' => 'ID', 'order_by_id' => 'DESC'],
        ['name' => 'username', 'orderable' => true, 'header' => 'Username', 'order_by_username' => 'DESC'],
        // ['name' => 'first_name', 'orderable' => true, 'header' => 'First name', 'order_by_first_name' => 'DESC'],
        // ['name' => 'last_name', 'orderable' => true, 'header' => 'Last name', 'order_by_last_name' => 'DESC'],
        ['name' => 'email', 'orderable' => true, 'header' => 'Email', 'order_by_email' => 'DESC'],
        ['name' => 'active', 'orderable' => true, 'header' => 'Active', 'order_by_active' => 'DESC'],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'created_at', 'order_by_email' => 'DESC'],
        ['name' => 'type', 'orderable' => true, 'header' => 'Type', 'order_by_type' => 'DESC'],
        ['name' => '2fa', 'orderable' => true, 'header' => '2FA', 'order_by_2fa' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => NULL]

    ];

    const ORDERABLE = [
        1 => 'last_name',
        2 => 'first_name',
        3 => 'email',
        4 => 'created_at',
    ];

    public static $orderable = ['last_name', 'first_name' , 'email', 'created_at'];

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
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder =  $this->db->table('users')
            ->select('*');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'inner');
        $builder->join('auth_identities', 'auth_identities.user_id = users.id', 'inner');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
            ->like('group', $search)
            ->orLike('username', $search)
            ->orLike('secret', $search)
            ->orLike('last_name', $search)
            ->orLike('first_name', $search)
            ->groupEnd();

        return $condition->where([
            'users.deleted_at'  => null,
            'users.deleted_at' => null,
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
          if(!empty($builder)){
            foreach($builder as $gp){
                $returnGroup[] = $gp['group'];
            }
          }
          return $returnGroup;
           
    }
}
