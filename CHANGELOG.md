# Changelog

All Notable changes to `laravel-notification-channels/webpush` will be documented in this file

## 1.0.0 (2024-12-04)


### Bug Fixes

* allow phpunit 9 and enable php coverage driver ([a7ed923](https://github.com/xcoorp/laravel-webpush-notifications/commit/a7ed923b84ec4862b08c1ba497c29cf015cc8332))
* cache key ([bec6ce8](https://github.com/xcoorp/laravel-webpush-notifications/commit/bec6ce80dfcad9ef55112c4f442ca8e37a946e7a))
* don't use deprecated set-output in github actions ([7a8719f](https://github.com/xcoorp/laravel-webpush-notifications/commit/7a8719f795616881b9ba982c9fb4fe1427d131b2))
* exclude unsupported configurations ([0a97b46](https://github.com/xcoorp/laravel-webpush-notifications/commit/0a97b467cb880c3978f8da94633bf9788915916c))
* ignore laravel 9.x on PHP 8.2 with prefer-lowest ([8d5d322](https://github.com/xcoorp/laravel-webpush-notifications/commit/8d5d322f1182ed5d31d79dd2555330f48b31d30b))
* job names ([aa435c1](https://github.com/xcoorp/laravel-webpush-notifications/commit/aa435c1c40a9ea6d5ee6929ca1fc62c65cdfc698))
* set minimum testbench for laravel 9.x ([ab199d8](https://github.com/xcoorp/laravel-webpush-notifications/commit/ab199d8b46be7ddf573f4418e605d105c4a2cfa7))
* stability is vary too ([d75e681](https://github.com/xcoorp/laravel-webpush-notifications/commit/d75e681112dff59829470d01d7019a58274686ab))
* testbench version restrictions ([6452692](https://github.com/xcoorp/laravel-webpush-notifications/commit/6452692b8adcce6e973e45350790a264de091630))


### Miscellaneous Chores

* add Laravel 9.x support ([59cd44e](https://github.com/xcoorp/laravel-webpush-notifications/commit/59cd44eb51b149d8b8db658ddcb44af9f4797584))
* allow laravel 10.x ([78be9ec](https://github.com/xcoorp/laravel-webpush-notifications/commit/78be9ec905576646b1351025c66a241c1653a1bf))
* bump web-push library to v9 ([b8b46b4](https://github.com/xcoorp/laravel-webpush-notifications/commit/b8b46b477bea6afbad9d851b75e1e9e9fbfea95b))
* drop support older php and laravel versions ([5412aca](https://github.com/xcoorp/laravel-webpush-notifications/commit/5412acae68a85dd9308eb58eb514123389876d90))
* prepare for laravel 11 ([1e64c81](https://github.com/xcoorp/laravel-webpush-notifications/commit/1e64c81847cf67217e42d19dbd954cce4e54e88a))
* **rewrite:** rewrite to our needs ([779ba87](https://github.com/xcoorp/laravel-webpush-notifications/commit/779ba8755aa82570add5b0eb7ef84512b2c62877))
* update github pipeline deps ([2583fd7](https://github.com/xcoorp/laravel-webpush-notifications/commit/2583fd76aa84edd17579ce86f3f18173b1ff89fe))
* update to web-push v8 ([1297bd1](https://github.com/xcoorp/laravel-webpush-notifications/commit/1297bd18abbf3141643a48896d233542baa98390))
* upgrade web-push to v7.0 ([0d0c167](https://github.com/xcoorp/laravel-webpush-notifications/commit/0d0c167c942d5f9e2cc4e60ba53e2e768ec28656))

## 8.0.0 - 2024-03-16

- Added support for Laravel 11.
  
## 7.1.0 - 2023-03-14

- Added support for Laravel 10.

## 7.0.0 - 2022-03-29

- Upgrade web-push dependency [#172](https://github.com/laravel-notification-channels/webpush/pull/172). 

## 6.0.0 - 2022-01-26

- Added support for Laravel 9.
- Dropped support for Laravel < 8 and PHP < 8.

## 5.1.1 - 2021-01-08

- Fixed action without icon [#130](https://github.com/laravel-notification-channels/webpush/issues/130).

## 5.1.0 - 2021-01-08

- Added PHP 8.0 support [#150](https://github.com/laravel-notification-channels/webpush/pull/150).
- Added `NotificationSent` and `NotificationFailed` [events](/src/Events).
- Removed `Log::warning` from `ReportHandler`.
- Switched to GitHub actions. 

## 5.0.3 - 2020-08-19

- Laravel 8.0 compatibility 

## 5.0.2 - 2020-03-05

- Laravel 7.0 compatibility 

## 5.0.1 - 2020-01-24

- Added the icon parameter to the action method.

## 5.0.0 - 2019-09-06

- Laravel 6.0 compatibility
- PHP 7.2 or greater is required
- Pass `$message` to [ReportHandler](/src/ReportHandler.php)

## 4.0.0 - 2019-07-28

- Upgraded to [minishlink/web-push](https://github.com/web-push-libs/web-push-php/releases) to v5
- Added `WebPushMessage::options()`
- Added [ReportHandler](/src/ReportHandler.php) to handle notification sent reports.
- Added options for customizing the model, table and connection.
- Added polymorphic relation. `HasPushSubscriptions` can now be used on any model.

## 3.0.0 - 2017-11-15

- Removed `id` and `create` methods from `WebPushMessage`.
- Added `badge`, `dir`, `image`, `lang`, `renotify`, `requireInteraction`, `tag`, `vibrate`, `data` methods on `WebPushMessage`.

## 2.0.0 - 2017-10-23

- Added support for package discovery.
- Removed compatibility with PHP<7 and upgrade deps.

## 1.0.0 - 2017-03-25

- Added support for VAPID.
- Added dedicated config file.

## 0.2.0 - 2017-01-26

- Added Laravel 5.4 compatibility.
