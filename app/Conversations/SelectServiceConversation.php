<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SelectServiceConversation extends Conversation
{

    public function askService()
    {
        $question = Question::create('Que tipo de serviço você está procurando?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('ENEM')->value('enem'),
                Button::create('Marketing Digital')->value('mkt'),
                Button::create('Religioso')->value('religious'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'service' => $answer->getValue(),
                ]);
                $this->bot->startConversation(new DateTimeConversation());
            }
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askService();
    }
}