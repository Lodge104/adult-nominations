Occoneechee Lodge, Order of the Arrow's Adult Nomination Portal
=========

This is the Adult Nomination Portal used by Occoneechee Lodge. This system allows for our lodge to track adult nominations from start to finish.

Our lodge uses LodgeMaster's Induction Module to track unit elections and youth candidates. LodgeMaster does not currently allow for the tracking and processing of adult nominations. This system is a solution until LodgeMaster eventually adopts the ability to do adult nominations.

The adult nomination process begins when a unit election is sent for approval in the induction module of LodgeMaster. If a unit has at least one scout elected, an administrator will create a unit profile in this system. They'll include the unit leader's information, the date of their election, and how many scouts were elected.

![Admin Dashboard](https://github.com/Lodge104/adult-nominations-auth0/blob/master/readme/admin-dashboard.png)

The adminstrator will then click a button to start the nomination process by sending an invitation email through the system.

The unit leader will get an email invitation with a link to a nomation dashboard. On the dashboard, it will show instructions and a button to submit nominations. The systems is able to calculate how many adult nominations are allowed based on the number of elected scouts previously entered for the unit. The system will prevent more nomations than allowed from being made.

![Unit Leader Dashboard](https://github.com/Lodge104/adult-nominations-auth0/blob/master/readme/unitleader-dashboard.png)

Once the unit leader submits the nomination, an automated invitation is sent to the unit chair to review it. The unit chair's information is provided in the nomination form. The unit chair cannot create nominations but can only review and edit ones created by the unit leader. Only certain fields are editable by the unit chair.

![Create Nomination](https://github.com/Lodge104/adult-nominations-auth0/blob/master/readme/nomination-form.png)

Once the unit chair approves the nomination, an automated email is sent to the selection committee. The selection committee then goes to it's own dashboard to review and approve/disapprove of the nomination. The information can be copied over to LodgeMaster by either the selection committee or a system admin.

![Selection Committee Dashboard](https://github.com/Lodge104/adult-nominations-auth0/blob/master/readme/selection-committee.png)

The system used Auth0.com as the user management and role access control. Our lodge uses Auth0 for all our systems to control access and give everyone one account. Similar to ArrowID.

##### Features

- User Management
- Automated Election Results
- Anonymous Voting
- Unit Leader Dashboard with pre-election access
- LodgeMaster Exporting

Technologies used:
------------------
##### Prerequisites

- `PHP` *_required_*
	- Minimum version: `7.0`
	- `pdo_mysql` extension required
	- Recommended to enable `shell_exec`

- `MySQL` *_required_*
	- Version `5.6+` recommended

##### Components loaded via Composer that are contained in this repo
- `jQuery`
	- Version `3.1`
	- Pulled in via composer
- `Bootstrap`
	- Version `4.4.1`
- `PHP-Mailer`
	- Version `6.2.0`
	- Pulled in via composer
- `auth0-PHP`
	- Version `7.6.1`
	- Pulled in via composer

##### General Recommendations

- Enable SSL on your site! [Get a free cert at LetsEncrypt](https://letsencrypt.org)
	 - Their free tool [Certbot](https://certbot.eff.org) makes this process virtually painless

- Linux server running [Apache](https://www.apache.org) or [Nginx](https://nginx.org) is preferred

- Host your database on an encrypted filesystem

Installation
------------

#### Clone the Repository
	$ git clone https://github.com/Lodge104/adult-nominations-auth0.git

#### Install Unit Elections Database
Find the `unitelections.sql` file in the root of this repository and import it into your MySQL database. This will create a new database called `elections`. This will keep your data seperate from user management data.

Then find the `unitelections-info-sample.php` file and rename it to `unitelections-info.php` leaving it in the site's root. Change the values within the file to match the `elections` database you just created.

