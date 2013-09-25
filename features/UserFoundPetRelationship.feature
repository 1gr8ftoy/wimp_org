Feature: User/FoundPet relationship
  A user should be able to own a FoundPet

  Background:
    Given The database is empty
      And I have a user

  Scenario: User has one of each type of found pet
    Given I have the following found pets:
      | petType | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   |
      | Dog     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com |
      | Cat     | Yellow    | Tabby            | Omaha                | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org |

     Then I should have 1 found "Dog"
      And I should have 1 found "Cat"
      And I should have 1 found "Other"

  Scenario: User has three of each type of found pet
    Given I have the following found pets:
      | petType | petColors   | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   |
      | Dog     | Black       | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com |
      | Dog     | Brown       | Barks funny      | Manhattan            | NY                    | dog.jpg  | John Smith  | john@smith.com |
      | Dog     | Red         | Stands up        | Long Island          | NY                    | dog.jpg  | John Smith  | john@smith.com |
      | Cat     | Yellow      | Tabby            | Omaha                | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Cat     | Black/White | Kitten           | Lincoln              | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Cat     | White       | Very skittish    | Omaha                | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue    | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org |
      | Other   | Green       | Sulcata Tortoise | Riverside            | CA                    | bird.jpg | Janet Smith | bird@lover.org |
      | Other   | Greem       | Monitor          | Fresno               | CA                    | bird.jpg | Janet Smith | bird@lover.org |

     Then I should have 3 found "Dog"s
      And I should have 3 found "Cat"s
      And I should have 3 found "Other"s

