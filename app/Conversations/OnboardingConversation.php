<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Validator;

class OnboardingConversation extends Conversation
{

    public function askName()
    {
        $this->ask('Qual o seu nome meu amigo?', function (Answer $answer) {

            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);
            $this->bot->types();
            $this->say('Prazer em conhecê-lo ' . $answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Por favor, qual o seu e-mail?', function (Answer $answer) {

            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Hmm, tem algo de errado com este e-mail. Por favor, tente de novo!');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $this->askMobile();
        });
    }

    public function askMobile()
    {
        $this->ask('Legal, legal. Agora me fala o seu celular', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);

            $this->say('Ótimo!!');

            $this->bot->startConversation(new SelectServiceConversation());
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askName();
    }
}