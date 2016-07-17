# WP Admin Notices
___
A Wordpress developer's plugin that makes adding notices less painful. I felt a need for something like this while working on a project and decided to make one.

### Setup
----
Althought this code can be used as a plugin, I reccomend using it within your own plugin, just include `admin-notices.php` in your code - otherwise if user accidently turns off this plugin your code will produce errors.

Using this code as a plugin is simple - just add folder to wp-content/plugins folder and turn it in the admin panel. For multisite turn this plugin network wide (if you want to have multisite funcionality of course).

### Usage

Plugin provides a very simple API, althought I reccomend using defined classes.
##### Functions (wrappers for creating objects):
- single site (not multisite) functions:
    - `add_user_notice( int $user_id, string $content [, array $args ] )`
    - `add_current_user_notice( string $content [, array $args ] )`
    - `add_users_notice( array $users_ids, string $content [, array $args ] )`
- multisite functions:
    - `mu_add_user_notice( int $user_id, string $content [, array $args ] )`
    - `mu_add_current_user_notice( string $content [, array $args ] )`
    - `mu_add_users_notice( array $users_ids, string $content [, array $args ] )`

##### Arguments:
- `$content` - Notice content. It gets wrapped in paragraph. Must be a string.
- `$args` - General arguments in an associative array. Possible are:
    -  `user_id` - User's ID for who you want to display notice. By default is set to current user id
    -  `type` - Notice's type. Possible are:
        - `"success"` (green)
        - `"error"` (red)
        - `"warning"` (orange)
        - _[default]_ `"info"` (blue)
        - `"blank"` (no color)
    -   `place` - Determines where the notice should be displayed. For now the possibilities are rather small:
        - _[default]_ `"all"` - notice is displayed everywhere on the admin panel
        - `post_id)` - notice is displayed on edit screen of a post of this id (works with products as well). Must be an intiger
        - `page_name` - id of an admin page (contained by WP_Screen object)
    -  `display` - Determines how notice should be displayed:
        - `until_closed` - Notice is displayed on the refreshes until gets deleted by link under it. Useful when you want to be sure that user has noticed your message
        - _[default]_ `"once"` - Notice is displayed just once and can be closed by X button

#### That should be enough to use this plugin, more info below:
###### Deleting all notices
You can delete all user notices by using `Admin_Notice::delete_all_user_notices( int $user_id )` for single sites and `MU_Admin_Notice::delete_all_user_notices( int $user_id )` if you want to remove global user notices.
###### Tests
You can remove comment in admin-notices.php saying "ONLY FOR TESTS" to launch test. Make sure you comment it again after the code gets executed (on viewing admin panel).


### That's all.
I hope someone finds it useful :)
