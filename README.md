# Telegram Bot

A Laravel package for handling Telegram bot for channels and direct message webhooks and message strategies.

## Features

- Webhook handling for Telegram bots
- Strategy pattern for different message types (text, file, poll, base64, etc.)
- Easily extendable and configurable

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