<?php

namespace CiviCoop\VragenboomBundle\Service;

use CiviCoop\VragenboomBundle\Entity\EindRapport;

class EindRapportGenerateor {
  
  public function createReport(EindRapport $rapport) {
    $html = "<table><thead><tr><th>Ruimte / Object</th><th>Actie</th><th>Opmerkingen</th><th>Status</th></tr></thead><tbody>";
  
    foreach($rapport->getRegels() as $regel) {
      $html .= sprintf("<tr>
                        <td>%s / %s</td>
                        <td>
                          <strong>%s</strong>
                          <p>%s</p>
                        </td>
                        <td>%s</td>
                        <td><p>%s</p><p>%s</p></td>
                        </tr>",
                         $regel->getRuimte(),
                         $regel->getObject(),
                         $regel->getActie(),
                         $regel->getActieRemark(),
                         $regel->getRemark(),
                         $regel->getVerantwoordelijke(),
                         $regel->getStatus()
          );
    }
    $html .= "</tbody></table>";
    $html .= "<p>".nl2br($rapport->getRemarks()) . "</p>";
    return $html;
  }
}

