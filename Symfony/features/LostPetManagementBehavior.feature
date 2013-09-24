@behavior @javascript
Feature: LostPet management
  A user needs to be able to manage their lost pet posts

  Background: User adds a lost pet
    Given The database is empty
      And I am on the homepage
      And I follow "Sign up"
      And I create an account
      And I activate my account
      And I am on the homepage
      And I post the following lost pet:
        | petType | petBreed | petName  | petComesWhenCalled | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Yorkie   | Joe      | Yes                | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |

  Scenario: User views lost pet post via edit page
    Given I am on the homepage
      And I follow "Edit my posts"
     When I wait until ".reports-grid-tile" is visible
      And I click on the ".reports-grid-tile" element
     Then I should see "Editing lost pet"
     When I follow "View post"
     Then the url should match "/lost/\d+"
      And I should see "Yorkie"

  Scenario: User changes a lost pet's contact name
    Given I am on the homepage
      And I follow "View lost pets"
     When I wait until ".reports-grid-tile" is visible
     Then I should see 1 ".reports-grid-tile" element
      And I click on the ".reports-grid-tile" element
     Then I should see "Edit post"
      And I should see "John Smith"
     When I follow "Edit post"
      And I wait until "lost_pet[contactName]" is visible
      And I fill in "lost_pet[contactName]" with "Janet Black"
      And I press "Update post"
     Then I should see "Janet Black"
      And I should not see "John Smith"

  Scenario: User deletes a lost pet post
    Given I am on the homepage
      And I follow "View lost pets"
     When I wait until ".reports-grid-tile" is visible
     Then I should see 1 ".reports-grid-tile" element
      And I click on the ".reports-grid-tile" element
     Then I should see "Delete post"
     When I follow "Delete post"
      And I confirm the popup
     Then I should see "Post deleted successfully"
      And I should see 0 ".reports-grid .reports-tile" elements