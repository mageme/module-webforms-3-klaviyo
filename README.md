# MageMe WebForms Klaviyo for Magento 2

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-klaviyo.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-klaviyo)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-klaviyo.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-klaviyo)
[![Magento](https://img.shields.io/badge/Magento-2.4.x-EE672F.svg?style=flat-square)](https://magento.com)
[![PHP](https://img.shields.io/badge/PHP-7.4%20–%208.5-777BB4.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/license-MageMe%20EULA-blue.svg?style=flat-square)](https://mageme.com/license/)

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

## Custom Magento development

Need a feature an extension doesn't cover, or a bespoke Magento build? MageMe takes on custom extension development and integration work.

→ **[Custom Magento development](https://mageme.com/magento-services/custom-development)**

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Bug reports and feature requests: [GitHub Issues](https://github.com/mageme/module-webforms-3-klaviyo/issues)

## License

Governed by the **MageMe End User License Agreement** ([mageme.com/license](https://mageme.com/license/)). This add-on is distributed free of charge.

---

**MageMe WebForms** is a no-code form builder for Magento 2 — conditional logic, multi-step forms, file uploads, and CRM integrations. → [Get WebForms](https://mageme.com/magento-2-form-builder.html)