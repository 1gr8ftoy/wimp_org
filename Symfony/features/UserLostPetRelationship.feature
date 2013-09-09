Feature: User/LostPet relationship
  A user should be able to own a LostPet

  Background:
    Given The database is empty
      And I have a user

  Scenario: User has lost pets
    Given I have the following lost pets:
      | petType | petColors | petDescription   | petHomeCity | petHomeState | contactName | contactEmail   |
      | Dog     | Black     | Spotted, one leg | New York    | NY           | John Smith  | john@smith.com |
      | Cat     | Yellow    | Tabby            | Omaha       | NB           | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue  | Macaw            | Corona      | CA           | Janet Smith | bird@lover.org |

     Then I should have 1 lost "Dog"
      And I should have 1 lost "Cat"

  Scenario: User has three of each type of lost pet
    Given I have the following lost pets:
      | petType | petColors   | petDescription   | petHomeCity | petHomeState | contactName | contactEmail   |
      | Dog     | Black       | Spotted, one leg | New York    | NY           | John Smith  | john@smith.com |
      | Dog     | Brown       | Barks funny      | Manhattan   | NY           | John Smith  | john@smith.com |
      | Dog     | Red         | Stands up        | Long Island | NY           | John Smith  | john@smith.com |
      | Cat     | Yellow      | Tabby            | Omaha       | NB           | Cat Lover   | cat@lover.org  |
      | Cat     | Black/White | Kitten           | Lincoln     | NB           | Cat Lover   | cat@lover.org  |
      | Cat     | White       | Very skittish    | Omaha       | NB           | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue    | Macaw            | Corona      | CA           | Janet Smith | bird@lover.org |
      | Other   | Green       | Sulcata Tortoise | Riverside   | CA           | Janet Smith | bird@lover.org |
      | Other   | Greem       | Monitor          | Fresno      | CA           | Janet Smith | bird@lover.org |

    Then I should have 3 lost "Dog"s
    And I should have 3 lost "Cat"s
    And I should have 3 lost "Other"s