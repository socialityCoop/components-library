# M.1 - Redirect legacy posts

This code uses a meta stored in the WP database that contains the legacy url, migrated from the old website, to redirect legacy articles (posts) to the new ones.

It can be added at the `funtions.php` of the template or (better) in site-specific plugin. 

You need to make sure that the url you get matches the structure of the url you have stored. Usual implications include:

- Does legacy url contain base url ? You may need to edit line.10
- Maybe you have just some part of the url. In that case you might want to need part of the `$requested_url_array` instead of the whole url.