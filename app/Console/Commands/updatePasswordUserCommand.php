<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Console\Command;
class updatePasswordUserCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chpwd:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change the password of a user.';
    /**
     * User model.
     *
     * @var object
     */
    private $user;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $details = $this->getDetails();
        
        $user = $this->user->updateUser($details);
        $this->display($user);
    }
    /**
     * Ask for admin details.
     *
     * @return array
     */
    private function getDetails() : array
    {
        $details['id'] = $this->ask('User ID');
        $details['current_password'] = $this->secret('Current password');
        
        while (! $this->isValidAuth($details['id'], $details['current_password'])) {
            $this->error('Password entered don\'t match our records');
            $details['current_password'] = $this->secret('Current password');
        }
        
        $details['password'] = $this->secret('New password');
        $details['confirm_password'] = $this->secret('Confirm password');
        while (! $this->isMatch($details['password'], $details['confirm_password'])) {
            if (! $this->isRequiredLength($details['password'])) {
                $this->error('Password must be more that six characters');
            }
            if (! $this->isMatch($details['password'], $details['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }
            $details['password'] = $this->secret('Password');
            $details['confirm_password'] = $this->secret('Confirm password');
        }
        return $details;
    }
    /**
     * Display created admin.
     *
     * @param array $admin
     * @return void
     */
    private function display(User $user) : void
    {
        $headers = ['id', 'Email'];
        $fields = [
            'Id' => $user->id,
            'email' => $user->email
        ];
        $this->info('Password changed for this user');
        $this->table($headers, [$fields]);
    }
    /**
     * Check if password is vailid
     *
     * @param string $password
     * @param string $confirmPassword
     * @return boolean
     */
    private function isValidAuth(int $user_id, string $password) : bool
    {
        $obj_user = User::find($user_id);
        return Hash::check($password, $obj_user->password);
    }
    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword) : bool
    {
        return $password === $confirmPassword;
    }
    /**
     * Checks if password is longer than six characters.
     *
     * @param string $password
     * @return bool
     */
    private function isRequiredLength(string $password) : bool
    {
        return strlen($password) > 6;
    }
}
