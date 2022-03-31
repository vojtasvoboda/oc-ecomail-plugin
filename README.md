# Ecomail plugin for OctoberCMS

Ecomail plugin for OctoberCMS adds connector to Ecomail API v2 and also subscribe component ready to use. No other plugin dependencies.

## Installation

After installing the plugin, you have to fill Ecomail credentials in CMS > Settings > Ecomail. You can find API Key at Ecomail > Account > Integrations.

## Using

You can use directly Ecomail client like that:

```
$api_key = \VojtaSvoboda\Ecomail\Models\Settings::get('api_key');
$ecomail = new Ecomail($api_key);
$ecomail->addSubscriber($list_id, $data);
```

or you can use predefined Subscribe October component.

**Feel free to send pull request!**

## Documentation

Ecomail API v2 documentation: https://ecomailczv2.docs.apiary.io/

## Contributing

Please send Pull Request to the master branch.

## License

Ecomail plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as
OctoberCMS platform.
