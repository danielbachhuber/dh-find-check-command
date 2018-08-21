danielbachhuber/dh-find-check-command
=====================================

Combines finding and checking whether the installation is still hosted.



Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing) | [Support](#support)

## Using

~~~
wp dh-find-check <path> [--fields=<fields>] [--field=<field>] [--format=<format>]
~~~

First, runs `wp find` to find all potential WordPress installations under
a given path, and builds a list of all potential paths. Next, runs
`wp host-check` to determine whether the installation is still hosted on
the server.

Installation list is only output at the end of execution. Data for each
installation includes:

* `wp_path` - Path to the WordPress installation.
* `version` - WordPress version.
* `db_host` - Host name for the database.
* `db_user` - User name for the database.
* `db_name` - Database name for the database.
* `status` - Hosting status (documented next).

Potential statuses include:

* `check-failed` - Something about the host check process failed.
* `no-wp-exists` - WordPress doesn't exist at the path.
* `no-wp-config` - No wp-config.php file was found for the installation.
* `error-db-connect` - Couldn't connect to the database using defined credentials.
* `error-db-select` - Connected to the database but couldn't select specific database.
* `missing-<http-code>` - WordPress installation isn't on the server.
* `hosted-maintenance` - WordPress installation is hosted but renders maintenance page.
* `hosted-php-fatal` - WordPress installation is hosted but has a PHP fatal.
* `hosted-broken-wp-login` - WordPress installation is hosted but the login page is broken.
* `hosted-valid-login` - WordPress installation is hosted on server and login page loads.

**OPTIONS**

	<path>
		Path to search the subdirectories of.

	[--fields=<fields>]
		Limit the output to specific row fields.

	[--field=<field>]
		Output a specific field for each row.

	[--format=<format>]
		Render output in a specific format.
		---
		default: table
		options:
		  - table
		  - json
		  - csv
		  - yaml
		  - count
		---

## Installing

Installing this package requires WP-CLI v2 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with:

    wp package install git@github.com:danielbachhuber/dh-find-check-command.git

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.

For a more thorough introduction, [check out WP-CLI's guide to contributing](https://make.wordpress.org/cli/handbook/contributing/). This package follows those policy and guidelines.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/danielbachhuber/dh-find-check-command/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/danielbachhuber/dh-find-check-command/issues/new). Include as much detail as you can, and clear steps to reproduce if possible. For more guidance, [review our bug report documentation](https://make.wordpress.org/cli/handbook/bug-reports/).

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/danielbachhuber/dh-find-check-command/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, [please follow our guidelines for creating a pull request](https://make.wordpress.org/cli/handbook/pull-requests/) to make sure it's a pleasant experience. See "[Setting up](https://make.wordpress.org/cli/handbook/pull-requests/#setting-up)" for details specific to working on this package locally.

## Support

Github issues aren't for general support questions, but there are other venues you can try: https://wp-cli.org/#support


*This README.md is generated dynamically from the project's codebase using `wp scaffold package-readme` ([doc](https://github.com/wp-cli/scaffold-package-command#wp-scaffold-package-readme)). To suggest changes, please submit a pull request against the corresponding part of the codebase.*
