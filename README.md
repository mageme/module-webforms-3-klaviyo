# MageMe WebForms 3 — Klaviyo Integration

Free add-on for [MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html) that integrates form submissions with Klaviyo.

## Features

- Add form submissions as Klaviyo profiles
- Subscribe profiles to Klaviyo lists
- Map form fields to custom profile properties

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- PHP `curl` and `json` extensions

## Installation

### Via Composer

```
composer require mageme/module-webforms-3-klaviyo
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual Installation

1. Download and extract to `app/code/MageMe/WebFormsKlaviyo/`
2. Run `bin/magento setup:upgrade`
3. Run `bin/magento cache:flush`

## Configuration

1. Navigate to **Stores > Configuration > MageMe > WebForms > Klaviyo** and enter your Klaviyo API key.
2. Open a form in the admin panel and configure the Klaviyo integration tab to select the target list and map form fields to profile properties.

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is a powerful form builder for Magento 2 that allows you to create any type of form — contact forms, surveys, registration forms, order forms, and more — with a drag-and-drop interface, conditional logic, file uploads, and CRM integrations.

[Get MageMe WebForms](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-klaviyo/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
