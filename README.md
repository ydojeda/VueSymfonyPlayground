# The Playground - A Blog Post Exercise

This serves as a repository for exploring and doing exercises in Vue and PHP. As Silex is no longer officially maintained, Symfony was chosen for the similarity in concepts. Symfony also ships with the Doctrine ORM which operates similarly to RedBean.

⚠️ Differences will be highlighted in the guide, and the focus of the exercise will be to learn important PHP and backend concepts that are not tied to a specific framework

# Getting Started

We will be making a blog post where you are able to create, update, and delete a blogpost and see the list of posts made by different users.

## Branching out and Exercise Structure

ℹ️ Checkout into a new branch and name it with your own name.

-   This will serve as your "feature" branch.
-   All your work will be merged into this feature branch.
-   The idea is to preserve the master state as a blank playground repository.

### Exercise Completions and Feedbacks

-   It is encouraged to do the following exercises in chunks where each chunk involves branching off of your feature branch. After each chunk of progress, a PR can be opened to your feature branch.
-   It is recommended to be opening reasonably small PRs to your feature branch
-   This will result into more feedback/guidance throughout the exercise and make it easier for the reviewer to test changes.

## Setting up

At this point you are in your own feature branch. This project is running on Symfony 4, be sure to use the version 4.x when checking its documentation. It also uses docker and assumes you've got it set up.
Install the Symfony CLI.

```
brew install symfony-cli/tap/symfony-cli
```

Install the project packages

```
composer install
yarn install
```

## Running the project

Make sure docker desktop is up when running the command:

```
docker-compose up -d
```

Run the symfony server:

```
symfony server:start
```

In another terminal, we build and serve the frontend assets powered by vue:

```
yarn encore dev-server --hot
```

Confirm that `localhost:8000` is running and Home is displayed.

# PHP Exercise

The goal of this exercise is to create CRUD endpoints that will be consumed by the vue project.

## Concepts for the Exercise

### Entities

Entities can be mapped to tables in the database, and the properties of an entity correspond to its own column in its associated table.

You can test it out and make your own entity by:

```
symfony console make:entity
```

Follow the prompts to define your entity. Once created, an Entity class and Entity Repository class would have been made (more information on repository class later).

### Migrations

We need a migration file to be able to inform the database of the changes we made to the entity (ie, a new entity has been created or updated). `symfony console make:migrations` will make the file that holds the instructions on what to update in the database, and `symfony console doctrine:migrations:migrate` will run those instructions.

**_In Redbean_**, you create the migration file and place the instructions in the class yourself before migrating your changes.

### Data for the Exercise

But for the following exercises, the entities and data needed have already been provided. For simplicity, there are two entities: `User` and `BlogPost`. The exercises will focus on CRUD operations on the `BlogPost`. For testing the responses of the endpoints to be created, load fixtures to the database:

```
symfony console doctrine:fixtures:load
```

A list of blog posts associated with different users should be loaded into the `main` database. To check the port number that docker used or see the complete `DATABASE_URL`, you may run

```
 symfony var:export --multiline
```

## Provider-Controller-Service-Repository Structure

Typically, endpoints are grouped into "feature" that hold a Provider, Controller, Service, and Repository class/layer.

-   **Providers**: responsible for defining routes and routing incoming requests to the corresponding controller
-   **Controllers**: process the requests and sending back the appropriate response. Validation is handled here and this is where calls to the appropriate services are made
-   **Services**: usually helper functions that implements business logic. Access data from the database through repositories
-   **Repositories**: handle logic for storing and retreiving data from the database

**_Folder structure_** may differ depending on conventions. A typical BlogPost feature may be grouped as

```
src
    +- BlogPost
        +- BlogPostProvider
        +- BlogPostController
        +- BlogPostService
        +- BlogPostRepository
```

In Symfony, folder structure differ and a BlogPost feature of endpoints would be structured as so:

```
src
    +- Controller
        +- BlogPostController
    +- Repository
        +- BlogPostService
    +- Service
        +- BlogPostRepository
```

Noticeably, there is no BlogPostProvider. Routes are handled inside the BlogPostController instead (see [here](https://symfony.com/doc/4.x/routing.html#creating-routes-as-annotations))

**Note**: It is good to keep these differences in mind as the goal of this exercise is not to learn Symfony but to learn the concepts that translate across frameworks.

## 🔵 Exercise Objectives

⚠️ For each objective, branch out of the feature branch and open separate PRs on its implementations

### ◻️ List of Users and Posts
-   Make GET endpoints to fetch the list of users and blog posts.
-   For blog posts, except a `limit` and `offset` that sets how many blogposts are fetched and defines the starting point of where they are fetched so that pagination may be implemented

### ◻️ Creating a BlogPost
-   Make an endpoint that creates a new blog post and stores it to the database
-   Handle appropriate validation and sanitation

### ◻️ Updating a BlogPost

-   Make an endpoint that updates the contents of a blogposts
-   Handle appropriate validation and sanitation

### ◻️ Deleting a BlogPost
-   Make an endpoint that allows deleting a blog post from the database
-   Handle appropriate validation and sanitation

### ◻️ User Reactions
- Create a table for `userreactions`.
- It should have the following properties: user_id (User), blog_post (BlogPost), has_reacted (Boolean). Make sure to migrate this properly.
- Make an endpoint that updates the has_reacted value of an entry:
  - It needs a user and a blog post
  - It will create an entry for that user and blog post if it does not exist
- Make an endpoint that returns the list of blog post ids that a specified user has reacted to


## Exercise Limitations

This exercise is focused on blog posts and treats Users as simply a required property of blog posts. The exercise was not set up for handling user authentication flows.

# Vue Exercise

In this section, an interface will be created to consume the endpoints in the previous exercise.

## Folder Structure

The frontend assets in this project are found in `assets/src` folder and uses Vue 3. From this point forward, all mentions of `src` refers to `assets/src`. It follows the structure:

```
assets/src
    +- pages
    +- router
    +- styles
    +- app.ts
    +- App.vue
```

-   `router/index.ts` are were the routes are defined in using `Vue Router` (see [documentation](https://router.vuejs.org/))
-   `pages/` are were all page components dwell.
-   `/components/` will hold all reusable components for the pages.
-   `/styles` hold the common `less` styling to be used across the components (see [documentation](https://lesscss.org/usage/))

Documentation for Vue 3 can be found [here](https://vuejs.org/guide/essentials/application.html).

## Icons

-   All icons will make use of the free package from [FontAwesome](https://fontawesome.com/docs/web/setup/packages#_2-install-your-package) which has already been setup in this project.
-   To use this, simply search their [icon directory](https://fontawesome.com/icons). Ensure that the chosen icon is from the free package and that you are viewing the vue code snipet in their example.

## 🔵 Exercise Objectives
- Make use of the existing `less` files in styling the following.
- Always type your variables, objects, and functions.

### ◻️ Vertical Navigation Bar
- Create a new page (it may be blank) so that there are at least two pages to navigate to
- For each page, it should have a navigation item in the bar.
- The navigation item is represented by an icon
- The navigation item should have an active state to indicate which page the user is currently in
- The navigation sticks to the left side of the screen.

### ◻️ Fetching and Storing the list of users
- Place the type for your User object in a folder `src/types`
- Place your helper functions for fetching (in this case the list of users) in a folder `src/api`
- We need a place to store some of the things we fetch from endpoints. Install the vuex package (see https://vuex.vuejs.org/installation.html#yarn)
- Create a new folder `src/store` and define your store in an `index.ts` file
- Make sure to separate your actions, getters, and mutations in different files:
  - Create the actions and mutations needed to fetch the list of users and commit it to the store
  - Create the actions and mutations needed to set a single user as the "current user"
  - Create the getters for the current user and the list of users

### ◻️ Displaying List of Users and Current User
- Create a component that displays a greeting "Hi, <Current User>"
  - underneath it, add a clickable "View as someone else..."
  - clicking the "View as someone else" toggles visibility of a search bar and list of users
  - Typing on the search bar filters the list of users
  - Tapping/Clicking on a user item in the list saves it as the new current user in store
- This component becomes sticky to the top upon scrolling
- Add this header in your home page.

### ◻️ Fetching Blog Posts
- Place the type for your Blog Post object in the folder `src/types`
- Place the helper function for fetching the list of blog posts in `src/api`
- Create the actions and mutations to fetch the list of blog posts and commit them to store
- Create the getter for the list of blog posts

### ◻️ Setting up Blogposts
- Add a title to your Home page: "Blog Posts"
- When navigating to this page, fetch the necessary information (users, posts)
- The page will have two tabs
  - All: default tab. displays all posts
  - My Posts: displays the posts of current user
- Make sure that the active tab updates the home component's state accordingly

### ◻️ Blog Post Card
- create a card component that displays blog information: creator's name, image, company, and address + post's text, tags, and creation date
- The card should also contain a button that displays the number of reactions the post has
- Use this card to display the list of posts in the Home component

### ◻️ Creating a new post
- In `src/api`, create a helper function to create a post request for a new post
- Create a form that allows you to input post text and post tags.
- The form should have a cancel button that navigates back to home page
- The form should have a submit button that makes a post request. The user assigned to this new post is the current user set in store.
- After submission, navigate to the list of posts. The new post should appear on the list

### ◻️ Reacting to a Post
- In `src/api`, create the necessary changes for:
  - fetching the list of blog post ids that the current user has reacted to and saving it to store
  - post request to change whether the current user has reacted to a specified blog
- In your blog post card, add a state to the reaction button:
  - "reacted state", if the user has already reacted to this post
  - default state, if the user has not reacted to this post
- On clicking the reaction button, it updates the flag in the database and toggles between the button states

### ◻️ Updating a Post
- In `src/api`, create a helper function to create a put request for updating an existing post
- In your blog post card, add an edit button beside the reaction button.
  - This button only appears on a card if the creator of the post is the current user
  - When clicked, this button navigates to the blog post form and the inputs are prefilled with the blog post data to be edited
    - Cancel button works the same
    - Save button updates the blog post instead of creating a new one

### ◻️ Deleting a Post
- In `src/api`, create a helper function to send a delete request for a blog post
- In your blog post card, add a delete button beside the edit button.
    - This button only appears on a card if the creator of the post is the current user
    - When clicked, the blog post is deleted and removed from the list of blog posts



# Original Exercises (Partial Examples)
The original exercises were done in two separate repositories:
- [SymfonyPlayground](https://github.com/ydojeda/SymfonyPlayground)
- [VuePlayground](https://github.com/ydojeda/VuePlayground)