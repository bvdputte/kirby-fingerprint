# Kirby 3 Fingerprint

A little utility to add cache-busting fingerprints to files in Kirby 3.
Re-uses the [`css()`](https://getkirby.com/docs/reference/templates/helpers/css) and [`js()`](https://getkirby.com/docs/reference/templates/helpers/js)-helpers in Kirby 3 as much as possible.

When the files are updated, new hashes are added to the filenames automatically; so browser cache gets busted.

## Installation

- unzip [master.zip](https://github.com/bvdputte/kirby-fingerprint/archive/master.zip) as folder `site/plugins/kirby-fingerprint` or
- `git submodule add https://github.com/bvdputte/kirby-fingerprint.git site/plugins/kirby-fingerprint`
- `composer require bvdputte/kirby-fingerprint`

💡 Add the following to your `.htaccess` file:

```
# Bust browsercache on CSS & JS files
# More info: https://github.com/bvdputte/kirby-fingerprint
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)\.([0-9a-z]{32})\.(js|css|png|jpe?g|gif|svg|ico)$ $1.$3 [L]
```

## Usage

```php
cssfingerprint("assets/styles.css");
// Output: <link href="//localhost:3000/assets/css/styles.db5796ea5bf253bb7be3526eb083e068.css" rel="stylesheet">
jsfingerprint("assets/scripts.js");
// Output: <script src="//localhost:3000/assets/js/scripts.1e9dd0c95e7b12ce96729501c7585deb.js"></script>
```

You can also use this on a `path` or `$file` objects:

```php
echo fingerprint($page->some_imagefield()->toFile()->root());
// Output: /var/www/mysite/content/home/testimage.0d859e73e897635c53e59407be9b32aa.jpg
echo $page->some_imagefield()->toFile()->fingerprint();
// Output: /var/www/mysite/content/home/testimage.0d859e73e897635c53e59407be9b32aa.jpg
```

💡 Always test if the file exists first!

## Advanced features

For more advanced features, such as subresource integrity, please checkout [bnomei's kirby3-fingerprint plugin](https://github.com/bnomei/kirby3-fingerprint).

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/bvdputte/kirby-fingerprint/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.