<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

// sleep(0.5);

/**
 * INICIANDO UMA CONVERSA
 */
$botman->hears('(oi|ola|eae|iai|eai|iae)', BotManController::class . '@startConversation');

$botman->hears('.*ajud.*', function ($bot) {

    $bot->reply('Está precisando de ajuda? Saiba que posso te ajudar te falando nosso site, nossa localização e 
        até mesmo contar um pouquinho do que fazemos!');
});

/**
 * WHATSAPP DE CONTATO
 */
$botman->hears('.*(whatsapp|whats|zap|numero|contato|telefone).*', function ($bot) {

    $bot->reply('Nosso whatsapp para contato é: (11) 945199418');
});

/**
 * SITE
 */
$botman->hears('.*site.*', function ($bot) {

    $link = "<a href='https://www.google.com.br' target='_blank'>www.google.com</a>";

    $bot->reply('O endereço do nosso site é <b>' . $link . '</b> Acesse agora mesmo para saber mais sobre nós! ');
});


/**
 * SOBRE A EMPRESA
 */
$botman->hears('.*(sobre a empresa|que voc(ê|e)s fazem|hist(o|ó)ria|pilares).*', function ($bot) {

    $bot->reply('Somos a empresa X, estamos há 15 anos no mercado trazendo máximos resultados para nossos clientes!');
});



$botman->hears('.*(vlw|obg|obrigado|obrigada|valew|valeu).*', function ($bot) {

    $bot->reply('Fico feliz em ter ajudado *u*');
});


$botman->hears('.*(tchau|xau|adeus|até mais|flw|falow|falou|bjs).*', function ($bot) {

    $user = $bot->userStorage()->find();

    $name = $user->get('name') ?? 'amigo(a)!';

    $bot->reply('Até mais ' . $name . '! Espero te ver em breve');
});


$botman->fallback(function ($bot) {
    $bot->reply('Desculpe, não consegui te entender :( Tente de novo!');
});