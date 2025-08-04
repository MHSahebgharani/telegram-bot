# Telegram Bot

A Laravel package for handling Telegram bot for channels and direct message webhooks and message strategies.

## Features

- Webhook handling for Telegram bots
- Strategy pattern for different message types (text, file, poll, base64, etc.)
- Easily extendable and configurable

## Creating a Telegram Bot

Before you can use this package, you need to create a Telegram bot and obtain a bot token:

1. Open the Telegram app and search for the official bot called [@BotFather](https://t.me/BotFather).
2. Start a chat with BotFather and type the command: `/newbot`
3. Follow the prompts to choose a name and a username for your bot (the username must end with "bot", e.g., `mychannelhelperbot`).
4. After completing the steps, BotFather will provide you with an API token. It will look like: `123456789:ABCdefGhIJKlmNoPQRstuVWXyz`
5. **Keep this token safe!** You’ll need it to connect your code to your Telegram bot.

Once you have your token, you can proceed with the installation and configuration steps below.

## Installation

Install via Composer:

```bash
composer require mhsahebgharani/telegram-bot
```

## Usage

1. **Set your bot token and webhook URL in your `.env` file:**

    ```env
    TELEGRAM_BOT_TOKEN=your-telegram-bot-token
    TELEGRAM_WEBHOOK_URL=https://yourdomain.com/api/telegram/webhook
    ```

2. **Set the webhook URL:**

    The package will read the webhook URL from your `.env` variable `TELEGRAM_WEBHOOK_URL`. Use the following artisan command to set your Telegram webhook URL:

    ```bash
    php artisan telegram:set-webhook
    ```
    This command will use the value of `TELEGRAM_WEBHOOK_URL` from your `.env` file.

3. Publish the config file (if using Laravel):

    ```bash
    php artisan vendor:publish --provider="TelegramBot\\TelegramServiceProvider"
    ```

4. Configure your Telegram bot token and webhook in `config/telegram.php` if needed.

5. Use the provided controllers and strategies to handle incoming messages.

6. **Test Route:**

    A test route is available at:
    
    ```
    POST /telegram/channel/post
    ```
    
    Use this route to test sending messages to your Telegram channel.

## Folder Structure

- `src/` - Main package source code
- `config/` - Configuration files

## Extending

You can add your own message strategies by implementing the `TelegramStrategyInterface` and registering them in the resolver.

## Author

Mohammad H Sahebgharani (<mhsahebgharani@gmail.com>)

## License

MIT