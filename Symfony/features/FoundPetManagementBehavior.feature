@behavior
Feature: FoundPet management
  A user needs to be able to manage their found pet posts

  Scenario: User adds a found pet
    Given I am logged in
      And I am on the homepage
      And I post the following found pet:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |

  Scenario: User changes a found pet's contact name
    Given I am logged in
      And I am on the homepage
      And I follow "View found pets"
     When I click on the ".reports-grid-tile" element
     Then I should see "Edit Post"
      And I should see "John Smith"
     When I follow "Edit Post"
      And I fill in "form-contactName" with "Janet Black"
      And I press "Save Changes"
     Then I should see "Janet Black"
      And I should not see "Janet Black"

  Scenario: User deletes a found pet post
    Given I am logged in
      And I am on the homepage
      And I follow "View found pets"
     When I click on the ".reports-grid-tile" element
     Then I should see "Delete Post"
     When I follow "Delete Post"
     Then I should see "Post deleted successfully"
      And I should see 0 ".reports-grid .reports-tile" elements
