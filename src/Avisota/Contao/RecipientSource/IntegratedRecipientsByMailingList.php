<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota
 * @license    LGPL-3.0+
 * @filesource
 */

namespace Avisota\Contao\RecipientSource;

use Avisota\Contao\Entity\MailingList;
use Avisota\Contao\Entity\Recipient;
use Contao\Doctrine\ORM\EntityHelper;

/**
 * Class AvisotaRecipientSourceIntegratedRecipients
 *
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    Avisota
 */
class IntegratedRecipientsByMailingList extends AbstractIntegratedRecipients
{
	/**
	 * @var MailingList[]
	 */
	protected $mailingLists;

	/**
	 * @param MailingList[] $mailingLists
	 */
	public function __construct(array $mailingLists)
	{
		$this->mailingLists = $mailingLists;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function loadRecipients()
	{
		if (empty($this->mailingLists)) {
			return array();
		}

		$entityManager = EntityHelper::getEntityManager();
		$queryBuilder = $entityManager->createQueryBuilder();

		$mailingListIds = array();
		foreach ($this->mailingLists as $mailingList) {
			$mailingListIds[] = $mailingList->id();
		}

		return $queryBuilder
			->select('r')
			->from('Avisota\Contao:Recipient', 'r')
			->innerJoin('Avisota\Contao:RecipientSubscription', 's.recipient=r.id')
			->where($queryBuilder->expr()->in('s.list', '?1'))
			->setParameter(1, $mailingListIds)
			->getQuery()
			->getResult();
	}
}
