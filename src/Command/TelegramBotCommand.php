<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \unreal4u\TelegramAPI\HttpClientRequestHandler;
use \unreal4u\TelegramAPI\TgLog;
use \unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

class TelegramBotCommand extends Command
{
    private const BOT_TOKEN = '5191336232:AAE4xJd3funHjQYrZhWi77ECyD1ndj4hsxA';
    private const A_USER_CHAT_ID = '@test_reminder_chat';
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:telegram';

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loop = \React\EventLoop\Factory::create();
        $handler = new HttpClientRequestHandler($loop);
        $tgLog = new TgLog(self::BOT_TOKEN, $handler);

        $sendMessage = new SendMessage();
        $sendMessage->parse_mode = 'Markdown';
        $sendMessage->chat_id = self::A_USER_CHAT_ID;
        $sendMessage->text = '💚 Напоминалка 💚 
        
        👉 Ответы на часто задаваемые вопросы Вы можете найти в прикрепленных сверху чата сообщениях (* Pinned messages *)';

        $tgLog->performApiRequest($sendMessage);
        $loop->run();

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
