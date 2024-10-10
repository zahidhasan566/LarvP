<?php

namespace App\Console\Commands;

use App\Mail\CustomEmail;
use App\Models\RegisteredVaccineUser;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';
    protected $description = 'Send an email every night at 8 PM';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch email data from the database
        //$emailData = RegisteredVaccineUser::whereDate('AppointmentDate', Carbon::tomorrow())->get();
        $emailData = RegisteredVaccineUser::all();

        if (!empty($emailData)){
            foreach ($emailData as $data) {
                // Send email using data from the database
                Mail::to($data->Email)->send(new CustomEmail($data));
            }

            $this->info('Emails have been sent successfully.');
        }


    }
}
