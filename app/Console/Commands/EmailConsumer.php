<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\MessageConsumer;
use Junges\Kafka\Facades\Kafka;

class EmailConsumer extends Command
{
    protected $signature = 'consume:email';

    protected $description = 'Отправляет сообщения';

    public function handle()
    {
        $consumer = Kafka::consumer(['email'])
            ->withBrokers(config('kafka.brokers'))
            ->withAutoCommit()
            ->withHandler(function (ConsumerMessage $message, MessageConsumer $consumer) {
                $message = $message->getBody();
                Mail::send('', [], function ($email) use($message){
                    $email->to($message['email']);
                    $email->subject('');
                });
            })
            ->build();

        $consumer->consume();
    }
}
