@behavior @javascript
Feature: FoundPet management
  A user needs to be able to manage their found pet posts

  Background: User adds a found pet
    Given The database is empty
      And I am on the homepage
      And I follow "Sign up"
      And I create an account
      And I activate my account
      And I am on the homepage
      And I post the following found pet:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |

  Scenario: User views found pet post via edit page
    Given I am on the homepage
      And I follow "Edit my posts"
     When I wait until ".reports-grid-tile" is visible
      And I click on the ".reports-grid-tile" element
     Then I should see "Editing found pet"
     When I follow "View post"
     Then the url should match "/found/\d+"
      And I should see "Joe"

  Scenario: User changes a found pet's contact name
    Given I am on the homepage
      And I follow "View found pets"
     When I wait until ".reports-grid-tile" is visible
      And I click on the ".reports-grid-tile" element
     Then I should see "Edit post"
      And I should see "John Smith"
     When I follow "Edit post"
      And I wait until "found_pet[contactName]" is visible
      And I fill in "found_pet[contactName]" with "Janet Black"
      And I press "Update post"
     Then I should see "Janet Black"
      And I should not see "John Smith"

  Scenario: User deletes a found pet post
    Given I am on the homepage
      And I follow "View found pets"
     When I wait until ".reports-grid-tile" is visible
      And I click on the ".reports-grid-tile" element
     Then I should see "Delete post"
     When I follow "Delete post"
      And I confirm the popup
     Then I should see "Post deleted successfully"
      And I should see 0 ".reports-grid .reports-tile" elements
