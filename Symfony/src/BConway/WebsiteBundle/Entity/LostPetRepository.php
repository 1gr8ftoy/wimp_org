<?php

namespace BConway\WebsiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LostPetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LostPetRepository extends EntityRepository
{
    public function findPets($filters = array())
    {
        $page = (array_key_exists('page', $filters) && is_numeric($filters['page'])) ? $filters['page'] : 1;
        $items_per_page = (array_key_exists('perpage', $filters) && is_numeric($filters['perpage'])) ? $filters['perpage'] : 9;
        $get_total_items_count = (array_key_exists('gettotalcount', $filters) && is_bool($filters['gettotalcount'])) ? $filters['gettotalcount'] : false;

        $builder = $this
            ->getEntityManager()
            ->createQueryBuilder();

        $builder
            ->select('lp')
            ->from('BConwayWebsiteBundle:LostPet', 'lp');

        if(!$get_total_items_count) {
            $builder
                ->setMaxResults($items_per_page)
                ->setFirstResult(($page - 1) * $items_per_page);
        }

        $builder
            ->orderBy('lp.updatedAt', 'DESC')
            ->where('lp.active = TRUE');

        if (array_key_exists('searchPetType', $filters) && $filters['searchPetType'] && $filters['searchPetType'] != 'All') {
            $builder->andWhere('lp.petType LIKE :pet_type')
                ->setParameter('pet_type', $filters['searchPetType']);
        }

        if (array_key_exists('searchPetBreed', $filters) && $filters['searchPetBreed']) {
            $builder->andWhere('lp.petBreed LIKE :pet_breed')
                ->setParameter('pet_breed', '%' . $filters['searchPetBreed'] . '%');
        }

        if (array_key_exists('searchPetHomeCity', $filters) && $filters['searchPetHomeCity']) {
            $builder->andWhere('lp.petHomeCity LIKE %:home_city')
                ->setParameter('home_city', $filters['searchPetHomeCity']);
        }

        if (array_key_exists('searchPetHomeState', $filters) && $filters['searchPetHomeState'] && $filters['searchPetHomeState'] != 'All') {
            $builder->andWhere('lp.petHomeState LIKE :home_state')
                ->setParameter('home_state', $filters['searchPetHomeState']);
        }

        if (array_key_exists('searchStartDate', $filters)
            && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $filters['searchStartDate'])
            && array_key_exists('searchEndDate', $filters)
            && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $filters['searchEndDate'])
        ) {
            // Create \DateTime objects from given dates
            $start_date = \DateTime::createFromFormat("d/m/Y H:i:s", ($filters['searchStartDate'] . ' 00:00:00'));
            $end_date = \DateTime::createFromFormat("d/m/Y H:i:s", ($filters['searchEndDate'] . ' 23:59:59'));

            if (is_a($start_date, 'DateTime') && is_a($end_date, 'DateTime')) {
                $builder
                    ->andWhere('lp.updatedAt BETWEEN :start_date AND :end_date')
                    ->setParameter('start_date', $start_date)
                    ->setParameter('end_date', $end_date);
            }
        }

        $query = $builder->getQuery();

        try {
            if($get_total_items_count) {
                return count($query->getArrayResult());
            } else {
                return $query->getArrayResult();
            }
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
