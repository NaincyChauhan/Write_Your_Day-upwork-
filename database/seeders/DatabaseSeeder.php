<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Policies;
use App\Models\Setting;
use App\Models\Role;
use App\Models\Permission;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user_role = new Role();
		$user_role->slug = 'user';
		$user_role->name = 'User';
		$user_role->save();

		$superadmin = new Role();
		$superadmin->slug = 'superadmin';
		$superadmin->name = 'Super Admin';
		$superadmin->save();

        $superadmin_role = Role::where('slug','superadmin')->first();

		$data = [
			//Banner
			// ['slug' => 'read-banner', 'name' => 'Read Banner'],
			// ['slug' => 'create-banner', 'name' => 'Create Banner'],
			// ['slug' => 'update-banner', 'name' => 'Update Banner'],
			// ['slug' => 'delete-banner', 'name' => 'Delete Banner'],

			//Extension
			// ['slug' => 'read-extension', 'name' => 'Read Extension'],
			// ['slug' => 'create-extension', 'name' => 'Create Extension'],
			// ['slug' => 'update-extension', 'name' => 'Update Extension'],
			// ['slug' => 'delete-extension', 'name' => 'Delete Extension'],

			//Sub-extension
			// ['slug' => 'read-subextension', 'name' => 'Read Sub-extension'],
			// ['slug' => 'create-subextension', 'name' => 'Create Sub-extension'],
			// ['slug' => 'update-subextension', 'name' => 'Update Sub-extension'],
			// ['slug' => 'delete-subextension', 'name' => 'Delete Sub-extension'],

			//Category
			// ['slug' => 'read-category', 'name' => 'Read category'],
			// ['slug' => 'create-category', 'name' => 'Create category'],
			// ['slug' => 'update-category', 'name' => 'Update category'],
			// ['slug' => 'delete-category', 'name' => 'Delete category'],

			// //Sub-category
			// ['slug' => 'read-subcategory', 'name' => 'Read Sub-category'],
			// ['slug' => 'create-subcategory', 'name' => 'Create Sub-category'],
			// ['slug' => 'update-subcategory', 'name' => 'Update Sub-category'],
			// ['slug' => 'delete-subcategory', 'name' => 'Delete Sub-category'],

			//Listing
			// ['slug' => 'read-listing', 'name' => 'Read Listing'],
			// ['slug' => 'create-listing', 'name' => 'Create Listing'],
			// ['slug' => 'update-listing', 'name' => 'Update Listing'],
			// ['slug' => 'delete-listing', 'name' => 'Delete Listing'],

			//Blog
			// ['slug' => 'read-blog', 'name' => 'Read Blog'],
			// ['slug' => 'create-blog', 'name' => 'Create Blog'],
			// ['slug' => 'update-blog', 'name' => 'Update Blog'],
			// ['slug' => 'delete-blog', 'name' => 'Delete Blog'],

			//Blog-category
			// ['slug' => 'read-blogcategory', 'name' => 'Read Blog-category'],
			// ['slug' => 'create-blogcategory', 'name' => 'Create Blog-category'],
			// ['slug' => 'update-blogcategory', 'name' => 'Update Blog-category'],
			// ['slug' => 'delete-blogcategory', 'name' => 'Delete Blog-category'],

			//Blog Tag
			// ['slug' => 'manage-blogtag', 'name' => 'Read Blog Tags'],

			//News
			// ['slug' => 'read-news', 'name' => 'Read News'],
			// ['slug' => 'create-news', 'name' => 'Create News'],
			// ['slug' => 'update-news', 'name' => 'Update News'],
			// ['slug' => 'delete-news', 'name' => 'Delete News'],

			//Video Gallery
			// ['slug' => 'read-video', 'name' => 'Read Video Gallery'],
			// ['slug' => 'create-video', 'name' => 'Create Video Gallery'],
			// ['slug' => 'update-video', 'name' => 'Update Video Gallery'],
			// ['slug' => 'delete-video', 'name' => 'Delete Video Gallery'],

			//Image Gallery
			// ['slug' => 'read-image', 'name' => 'Read Image Gallery'],
			// ['slug' => 'create-image', 'name' => 'Create Image Gallery'],
			// ['slug' => 'update-image', 'name' => 'Update Image Gallery'],
			// ['slug' => 'delete-image', 'name' => 'Delete Image Gallery'],

			//Testimonials
			// ['slug' => 'read-testimonial', 'name' => 'Read Testimonial'],
			// ['slug' => 'create-testimonial', 'name' => 'Create Testimonial'],
			// ['slug' => 'update-testimonial', 'name' => 'Update Testimonial'],
			// ['slug' => 'delete-testimonial', 'name' => 'Delete Testimonial'],

			//Notice
			// ['slug' => 'read-notice', 'name' => 'Read Notice'],
			// ['slug' => 'create-notice', 'name' => 'Create Notice'],
			// ['slug' => 'update-notice', 'name' => 'Update Notice'],
			// ['slug' => 'delete-notice', 'name' => 'Delete Notice'],

			//Events
			// ['slug' => 'read-event', 'name' => 'Read Event'],
			// ['slug' => 'create-event', 'name' => 'Create Event'],
			// ['slug' => 'update-event', 'name' => 'Update Event'],
			// ['slug' => 'delete-event', 'name' => 'Delete Event'],

			//Achievements
			// ['slug' => 'read-achievement', 'name' => 'Read Achievement'],
			// ['slug' => 'create-achievement', 'name' => 'Create Achievement'],
			// ['slug' => 'update-achievement', 'name' => 'Update Achievement'],
			// ['slug' => 'delete-achievement', 'name' => 'Delete Achievement'],

			//Services
			// ['slug' => 'read-service', 'name' => 'Read Service'],
			// ['slug' => 'create-service', 'name' => 'Create Service'],
			// ['slug' => 'update-service', 'name' => 'Update Service'],
			// ['slug' => 'delete-service', 'name' => 'Delete Service'],

			//Products
			// ['slug' => 'read-product', 'name' => 'Read Product'],
			// ['slug' => 'create-product', 'name' => 'Create Product'],
			// ['slug' => 'update-product', 'name' => 'Update Product'],
			// ['slug' => 'delete-product', 'name' => 'Delete Product'],

			//Colleges
			// ['slug' => 'read-college', 'name' => 'Read Colleges'],
			// ['slug' => 'create-college', 'name' => 'Create Colleges'],
			// ['slug' => 'update-college', 'name' => 'Update Colleges'],
			// ['slug' => 'delete-college', 'name' => 'Delete Colleges'],

			//Notification
			// ['slug' => 'read-notification', 'name' => 'Read Notification'],
			// ['slug' => 'create-notification', 'name' => 'Create Notification'],
			// ['slug' => 'update-notification', 'name' => 'Update Notification'],
			// ['slug' => 'delete-notification', 'name' => 'Delete Notification'],

			//Role
			['slug' => 'read-role', 'name' => 'Read Role & Permission'],
			['slug' => 'create-role', 'name' => 'Create Role & Permission'],
			['slug' => 'update-role', 'name' => 'Update Role & Permission'],
			['slug' => 'delete-role', 'name' => 'Delete Role & Permission'],

			//Staff
			['slug' => 'read-staff', 'name' => 'Read Staff'],
			['slug' => 'create-staff', 'name' => 'Create Staff'],
			['slug' => 'update-staff', 'name' => 'Update Staff'],
			['slug' => 'delete-staff', 'name' => 'Delete Staff'],

			//User
			['slug' => 'read-user', 'name' => 'Read User'],
			['slug' => 'create-user', 'name' => 'Create User'],
			['slug' => 'update-user', 'name' => 'Update User'],
			['slug' => 'delete-user', 'name' => 'Delete User'],

			//Setting
			['slug' => 'update-setting', 'name' => 'Update Setting'],

			//Policy
			['slug' => 'update-policy', 'name' => 'Update Policy'],

			//About
			['slug' => 'update-about', 'name' => 'Update About'],

			//Director Message
			// ['slug' => 'update-director-message', 'name' => 'Update Director Message'],

			//Read Enquiry
			['slug' => 'read-Enquiry', 'name' => 'Read Enquiry'],
			['slug' => 'delete-Enquiry', 'name' => 'Delete Enquiry'],

			//Reporting
			// ['slug' => 'global-read-report', 'name' => 'Global Read Report'],
			// ['slug' => 'read-report', 'name' => 'Read Report'],
		];

		foreach($data as $d)
		{
			$superadmin_permission = new Permission();
			$superadmin_permission->slug = $d['slug'];
			$superadmin_permission->name = $d['name'];
			$superadmin_permission->save();
			$superadmin_permission->roles()->attach($superadmin_role);
		}
		
        $superadmin_perm = Permission::get();

        $user = new User();
        $user->name = "Admin";
        $user->email = "demo@haxways.com";
        $user->username = "haxways";
        $user->password = Hash::make("12345678");
        $user->save();
        $user->roles()->attach($superadmin_role);
		$user->permissions()->attach($superadmin_perm);

        $policy = new Policies();
        $policy->term = "Terms And Conditions";
        $policy->policy = "Privacy Policy";
        $policy->refund = "Refund Policy";
        $policy->save();


        $setting = new Setting();
        $setting->save();
    }
}
