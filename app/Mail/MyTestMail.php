<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $details;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(isset($this->details['file'])){
            return $this->from('admin@ba.com')
                        ->subject($this->details['title'])
                        ->attach($this->details['file'])
                        ->view($this->details['view']);
        } else {
            return $this->from('admin@ba.com')
                        ->subject($this->details['title'])
                        ->view($this->details['view']);
        }
    }
}