# Magento 2 Klaviyo Integration — MageMe WebForms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-klaviyo.svg)](https://packagist.org/packages/mageme/module-webforms-3-klaviyo)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-klaviyo.svg)](https://packagist.org/packages/mageme/module-webforms-3-klaviyo)
[![License: Proprietary](https://img.shields.io/badge/license-proprietary-blue.svg)](https://mageme.com/license/)

Grow your Klaviyo email and SMS lists from Magento 2 forms. This free add-on for [MageMe WebForms](https://mageme.com/magento-2-form-builder.html) turns every form submission into a Klaviyo profile — complete with custom properties, list subscriptions, and consent tracking.

## Features

- Create or update Klaviyo profiles from form submissions (identified by email or phone)
- Subscribe profiles to one or multiple Klaviyo lists per form
- Track email and SMS consent automatically
- Map form fields to custom profile properties for segmentation
- Enrich profiles with location data (address, city, country, coordinates, timezone)
- Multi-store support with per-store API token configuration
- Resend submissions to Klaviyo manually from the Magento admin panel

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- PHP `curl` and `json` extensions
- Klaviyo account with API access

## Installation

```
composer require mageme/module-webforms-3-klaviyo
bin/magento setup:upgrade
bin/magento cache:flush
```

## Configuration

1. Go to **Stores > Configuration > MageMe > WebForms > Klaviyo** and enter your Klaviyo API keys.
2. Open any form in the admin panel and configure the Klaviyo integration tab — select target lists and map form fields to profile properties.

## Other MageMe WebForms Integrations

Build a connected Magento 2 storefront with more integrations:

- [Mailchimp](https://github.com/mageme/module-webforms-3-mailchimp) — subscribe customers with interest groups
- [HubSpot](https://github.com/mageme/module-webforms-3-hubspot) — sync contacts, companies, and tickets
- [Salesforce](https://github.com/mageme/module-webforms-3-salesforce) — create leads from form submissions
- [Zoho CRM & Desk](https://github.com/mageme/module-webforms-3-zoho) — create leads and support tickets
- [Freshdesk](https://github.com/mageme/module-webforms-3-freshdesk) — create support tickets automatically
- [Zendesk](https://github.com/mageme/module-webforms-3-zendesk) — create tickets with custom field types
- [Zapier](https://github.com/mageme/module-webforms-3-zapier) — connect forms to 7000+ apps

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is the go-to form builder for Magento 2 stores. Create contact forms, lead capture forms, surveys, and registration forms with conditional logic, multi-step layouts, file uploads, and direct CRM integrations — all from the admin panel.

[Get MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-klaviyo/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
