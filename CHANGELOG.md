# Change log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.0] - 2023-09-11

* Updated PHP requirement to 8.1 and above (7.4 and 8.0 dropped) [PR#28](https://github.com/mikebarlow/megaphone/pull/28)
* Updated to Livewire 3 [PR#28](https://github.com/mikebarlow/megaphone/pull/28)
* Updated Testbench and Pest [PR#28](https://github.com/mikebarlow/megaphone/pull/28)

## [1.2.0] - 2023-02-25

* Removed `public $user` from component and changed loading of announcements to prevent user model data exposure. [PR #22](https://github.com/mikebarlow/megaphone/pull/22)
* Added ability to pass in the notifiableId via component render

## [1.1.0] - 2022-12-27

* Improvement: New SVG Bell Icon [PR #17](https://github.com/mikebarlow/megaphone/pull/17)
* Improvement: New config option to toggle unread notification count [PR #17](https://github.com/mikebarlow/megaphone/pull/17)
* Fix: Notification badge styling with long unread notification counts [PR #17](https://github.com/mikebarlow/megaphone/pull/17)
* Fix: Readme typo [PR #16](https://github.com/mikebarlow/megaphone/pull/16)

## [1.0.2] - 2022-11-15

* Improvement: Removed the mouse over event for marking as read and added a button with click event to mark notification as read.

## [1.0.1] - 2022-11-13

* Fix: Numerous Readme updates, fixing incorrect instructions. Demo also added! [PR #10](https://github.com/mikebarlow/megaphone/pull/10)
* Fix: Spelling mistake in template caused bug with justified items [PR #5](https://github.com/mikebarlow/megaphone/pull/5)
* Fix: Added support for PHP7.4 [PR #13](https://github.com/mikebarlow/megaphone/pull/13)

## [1.0.0] - 2022-09-19

* Livewire Component to add "Bell" notification icon to your app powered by Laravel Notifications
* Livewire Admin Component for sending manual notification to all users
* Console command to clear old read notifications
* Ability to define custom notification types
* Uses TailwindCSS for styling with publishable templates to customise look and feel
* 100% Test coverage
