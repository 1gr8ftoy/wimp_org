@behavior
Feature: LostPet management
  A user needs to be able to manage their lost pet posts

  Scenario: User adds a lost pet
    Given I am logged in
      And I am on the homepage
      And I post the following lost pet:
        | petType | petBreed | petName  | petComesWhenCalled | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Yorkie   | Joe      | Yes                | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |

  Scenario: User changes a lost pet's contact name
    Given I am logged in
      And I am on the homepage
      And I follow "View lost pets"
     Then I should see 1 ".reports-grid .reports-tile" element
     When I click on the ".reports-grid-tile" element
     Then I should see "Edit Post"
      And I should see "John Smith"
     When I follow "Edit Post"
      And I fill in "form-contactName" with "Janet Black"
      And I press "Save Changes"
     Then I should see "Janet Black"
      And I should not see "Janet Black"

  Scenario: User deletes a lost pet post
    Given I am logged in
      And I am on the homepage
      And I follow "View lost pets"
     Then I should see 1 ".reports-grid .reports-tile" element
     When I click on the ".reports-grid-tile" element
     Then I should see "Delete Post"
     When I follow "Delete Post"
     Then I should see "Post deleted successfully"
      And I should see 0 ".reports-grid .reports-tile" elements
