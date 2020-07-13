<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Validator;

class GreetingConversation extends Conversation
{

    /**
     * BOT pergunta o nome do usuário
     *
     * @return void
     */
    public function askName()
    {
        $this->say('Oi, me chamo robô e vou te ajudar!');

        $this->ask('Para começar, me fala o seu primeiro nome', function (Answer $answer) {

            if (str_word_count($answer->getText()) != 1) {
                return $this->repeat('Ops, por favor, me diga apenas seu primeiro nome ;)');
            }

            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);

            $this->askEmail();
        });
    }

    /**
     * BOT pergunta o e-mail do usuário
     *
     * @return void
     */
    public function askEmail()
    {
        $userStorage = $this->bot->userStorage()->find();
        $question = 'Prazer ' . $userStorage->get('name') . '! Agora, por favor, digite o seu e-mail';

        $this->ask($question, function (Answer $answer) {

            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('Hmm, tem algo de errado com este e-mail. Por favor, tente de novo!');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $userStorage = $this->bot->userStorage()->find();

            $user = new User();
            $user->name = $userStorage->get('name');
            $user->email = $userStorage->get('email');
            $user->save();

            $this->say('Legal! Te cadastrei aqui ' . $user->name . '. Fique a vontade para fazer perguntas :)');
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