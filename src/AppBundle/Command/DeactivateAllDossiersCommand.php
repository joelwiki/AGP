<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 4/17/18
 * Time: 4:36 PM
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeactivateAllDossiersCommand extends ContainerAwareCommand {

    private $em;

    protected function configure() {
        $this->setName('app:deactivateAllDossiers');
    }

    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $global = $this->em->getRepository('AppBundle:GlobalParameters')->find(1);

        $today = new \DateTime('now');
        $endOfYearDate = $global->getEndOfYearDate();

        if ($today->format('d-m-Y') == $endOfYearDate->format('d-m-Y')) {
            foreach ($this->em->getRepository('AppBundle:Dossier')->findAllActivatedDossiers() as $dossier) {
                // Disable dossier
                $dossier->setEnabled(0);

                // Remove civil certificate
                $this->em->remove($dossier->getCivilLiabilityCertificate());
            }
        } else {
            return true;
        }

        $this->em->flush();
    }
}