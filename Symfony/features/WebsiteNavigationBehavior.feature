@behavior
Feature: A user needs to be able to successfully navigate throughout the website

  Scenario: User needs to be able to view the home page
    Given I am on the homepage
     Then I should see "Have you lost your best friend?"

  Scenario: User needs to be able to sign up on the website
    Given I am on the homepage
      And I follow "Sign up"
      And I create an account
      And I activate my account
      And I am on the homepage
     Then I should see "Edit my account"

  Scenario: A second user needs to be able to sign up on the website
    Given I am on the homepage
      And I follow "Sign up"
      And I create an account as "TestUser2"
      And I activate my account
      And I am on the homepage
     Then I should see "Edit my account"

  Scenario: User should be able to post lost pets
    Given I am logged in
      And I am on the homepage
      And I post the following lost pets:
        | petType | petBreed | petName  | petComesWhenCalled | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Yorkie   | Joe      | Yes                | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |
        | Cat     | Calico   | Garfield | No                 | Yellow    | Tabby            | Omaha       | NB           | Omaha, NB           | io7g08gyo97   | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-6556 |
        | Other   | Macaw    | Roger    | No                 | Red/Blue  | Macaw            | Corona      | CA           | Corona, CA          | 2woy28yv927et | bird.jpg | Janet Smith | bird@lover.org | (555) 511-2662 |
      And I follow "Edit my posts"
     Then I should see 3 "div.lost-pets .reports-grid .reports-tile" elements

  Scenario: A second user should be able to post lost pets
    Given I am logged in as "TestUser2"
    And I am on the homepage
    And I post the following found pets:
      | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
      | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | cat.jpg  | John Smith  | john@smith.com | (555) 511-2687 |
      | Cat     | Calico  | Yellow    | Tabby            | Omaha                | NB                    | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-7653 |
      | Other   | Macaw   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org | (555) 511-9853 |
    And I follow "Edit my posts"
    Then I should see 3 "div.found-pets .reports-grid .reports-tile" elements

  Scenario: User should be able to post found pets
    Given I am logged in
      And I am on the homepage
      And I post the following found pets:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |
        | Cat     | Calico  | Yellow    | Tabby            | Omaha                | NB                    | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-7653 |
        | Other   | Macaw   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org | (555) 511-9853 |
      And I follow "Edit my posts"
     Then I should see 3 "div.found-pets .reports-grid .reports-tile" elements

  Scenario: A second user should be able to post found pets
    Given I am logged in as "TestUser2"
      And I am on the homepage
      And I post the following found pets:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |
        | Cat     | Calico  | Yellow    | Tabby            | Omaha                | NB                    | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-7653 |
        | Other   | Macaw   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org | (555) 511-9853 |
      And I follow "Edit my posts"
     Then I should see 3 "div.found-pets .reports-grid .reports-tile" elements

  Scenario: User needs to be able to view all reported lost pets
    Given I am logged in
      And I am on the homepage
      And I follow "View lost pets"
     Then I should see "Browsing lost pet reports"
      And I should see 6 ".reports-grid .reports-tile" elements

  Scenario: User needs to be able to view all reported lost pets
    Given I am logged in
      And I am on the homepage
      And I follow "View lost pets"
     Then I should see "Browsing lost pet reports"
      And I should see 6 ".reports-grid .reports-tile" elements

  Scenario: User needs to be able to filter visible lost pets
    Given I am on the homepage
      And I follow "View lost pets"
     When I press "Search/Filter"
      And I select "Dog" from "search_type"
      And I fill in "search_breed" with "Some breed"
      And I fill in "search_city" with "City"
      And I select "Alabama" from "search_state"
      And I fill in "search_start_date" with "01/01/2001"
      And I fill in "search_end_date" with "12/31/2001"
      And I press "Search"
     Then I should see 6 ".reports-grid .reports-tile" elements
     When I press "Search/Filter"
      And I select "Dog" from "search_type"
      And I press "Search"
     Then I should see 2 ".reports-grid .reports-tile" elements
      And I should see "Lost dog!"
      And I should not see "Lost cat!"
      And I should not see "Lost pet!"
     When I press "Search/Filter"
      And I select "Cat" from "search_type"
      And I press "Search"
     Then I should see 2 ".reports-grid .reports-tile" elements
      And I should not see "Lost dog!"
      And I should see "Lost cat!"
      And I should not see "Lost pet!"
     When I press "Search/Filter"
      And I select "Other" from "search_type"
      And I press "Search"
     Then I should see 2 ".reports-grid .reports-tile" elements
      And I should not see "Lost dog!"
      And I should not see "Lost cat!"
      And I should see "Lost!"
     When I press "Reset Search/Filter"
     Then I should see 6 ".reports-grid .reports-tile" elements

  Scenario: User needs to be able to view all reported found pets
    Given I am logged in
      And I am on the homepage
      And I follow "View found pets"
     Then I should see "Browsing found pet reports"
      And I should see 6 ".reports-grid .reports-tile" elements

  # TODO: Scenario: User needs to be able to filter visible found pets

  Scenario: User needs to be able to send us a message via the contact page
    Given I am on the homepage
      And I follow "Contact us"
     When I fill in "form-name" with "Website user"
      And I fill in "form-email" with "website@user.com"
      And I fill in "form-subject" with "Test message"
      And I fill in "form-subject" with "This is a test message sent using the contact form"
      And I press "Send Message"
     Then email with subject "WhereIsMyPet.org message: Test message" should have been sent

  Scenario: User should be able to logout
    Given I am logged in
     Then I should not see "Login"
     When I follow "Logout"
     Then I should see "Login"
      And I should not see "Logout"