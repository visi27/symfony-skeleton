Feature: Product admin panel
  In order to maintain the products on the site
  As an admin
  I need to be able to add/edit/delete products

  Background:
    Given I am logged in as an admin

  Scenario: List available blog posts
    Given there are 5 articles
    And there is 1 article
    And I am on "/admin/blog/list"
    Then I should see 6 articles

  Scenario: Show published/unpublished
    Given the following articles exist:
      | title        | summary           | is published |
      | Awsome Behat | Lorem Ipsum Behat | yes          |
      | Awsome BDD   | Lorem Ipsum BDD   | no           |
    When I go to "/admin/blog/list"
    Then the "Awsome Behat" row should have a check mark

  Scenario: Deleting a product
    Given the following articles exist:
      | title        | summary           |
      | Awsome Behat | Lorem Ipsum Behat |
      | Awsome BDD   | Lorem Ipsum BDD   |
    When I go to "/admin/blog/list"
    And I click "Delete" in the "Awsome Behat" row
    Then I should see "The blog post was deleted"
    And I should not see "Awsome Behat"
    But I should see "Awsome BDD"


  Scenario: Add a new product
    Given there is a category named "Behat"
    And I am on "/admin/blog/list"
    When I click "New Article"
    And I fill in "Title" with "Awsome Behat"
    And I select "Behat" from "app_bundle_blog_post_form_type_category"
    And I fill in "Summary" with "Awsome BDD Development With behat"
    And I fill in "Content" with "Have your velociraptor chew on this instead!"
    And I select "Yes" from "app_bundle_blog_post_form_type_isPublished"
    And I fill in "app_bundle_blog_post_form_type_publishedAt" with "2017-05-25"
    And I press "Save"
    Then I should see "Blog Post Created!"
    And I should see "Awsome Behat"

