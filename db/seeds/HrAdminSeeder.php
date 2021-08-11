<?php


use Phinx\Seed\AbstractSeed;

class HrAdminSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'user_name'     => 'Violet Gallegos',
                'password'      => md5('Pacific1#'),
                'email_id' => 'vgallegos@pct.com',
                'is_hr_admin' => 1,
                'is_super_hr_admin' => 1,
                'status'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $posts = $this->table('admin');
        $posts->insert($data)
              ->save();
    }
}
