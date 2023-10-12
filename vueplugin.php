<?php
/*
Plugin Name: Latest Posts
Description: Latest posts shortcode
Version: 1.0
*/
add_action('wp_enqueue_scripts', 'enqueue_scripts');
function enqueue_scripts(){
    global $post;
    if(has_shortcode($post->post_content, "latestPosts")){
        wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js', [], '2.5.17');
        wp_enqueue_script('VueRouter', 'https://unpkg.com/vue-router@3.5.2/dist/vue-router.js', [], '2.5.17');
        wp_enqueue_script('latest-posts', plugin_dir_url( __FILE__ ) . 'latest-posts.js', [], '1.0', true);    
        
        
       
    }  
        
 } 
function handle_shortcode() {
    return '<div id="app">
              <router-link to="/">Home</router-link> |
              <router-link to="/about">About</router-link> |
              <router-link to="/contact">Contact</router-link>
              <router-view></router-view>
            </div>
            <div id="mount"></div>';
}
add_shortcode('latestPosts', 'handle_shortcode');

function custom_posts_endpoint_permissions() {
    $custom_permissions = array(
        'read' => true,
        'write' => false,
        'delete' => false,
    );

    // Apply custom permissions to the 'wp-json/wp/v2/posts' endpoint.
    register_rest_route('wp/v2', '/posts', array(
        'methods' => 'GET', // Adjust this to customize the HTTP method.
        'callback' => 'your_callback_function',
        'permission_callback' => function () use ($custom_permissions) {
            return current_user_can('edit_posts') ? $custom_permissions['write'] : $custom_permissions['read'];
        },
    ));
}

add_action('rest_api_init', 'custom_posts_endpoint_permissions');
function your_callback_function($request) {
    // Your custom logic goes here.
    $response_data = array(
        'message' => 'This is a custom response from your_callback_function.',
    );

    // Create a response object.
    $response = new WP_REST_Response($response_data);

    // Set the response status.
    $response->set_status(200);

    return $response;
}
