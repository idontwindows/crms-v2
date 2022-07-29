<?php

namespace frontend\models;

use Yii;


class Tooltip
{
    public function tooltips($id)
    {
        switch ($id) {
            case 'a1':
                return 'Performance of DOST does not meet meet most or did not meet any of the expectations of the customers served. There are a number of elements or aspects in DOST\'s service that reflects a serious problem for which DOST has not yet identified corrective actions. if there were corrective actions, then the action is perceived by the customers served as very ineffective or has totally been disregarded.';
                break;
            case 'a2':
                return 'Performance of DOST does not meet the minimum expectations of the customers served. There are several elements or aspects in DOST\'s service that reflects a problem for which DOST has not yet identified corrective actions, then the action is perceived by the customer as ineffective or has not been fully implemented to be effective.';
                break;
            case 'a3':
                return 'This is the midpoint in which the respondents cannot truly pick a side in the spectrum. However this does not mean that the respondents have no opinion or do not know. Performance of DOST neither meets nor does not meet the minimum expectations of the customers served.';
                break;
            case 'a4':
                return 'Performance of DOST meets the minimum expectations of the customers served. The service was provided with a few minor problems or none at all. if there were few minor problems, a corrective action might have already taken place which is deemed highly effective.';
                break;
            case 'a5':
                return 'Performance of DOST meets and excceds the needs and expectations for the customer served. The service was provided with a few minor problems or none at all. if there were few minor problems, a corrective action might have already taken place which is deemed highly effective.';
                break;
            case 'b1':
                return 'These are the service attributes that the customers considered as the least important. DOST should not focus on these attributes and aspects of public service delivery which have the least impact on the customers\' satisfaction.';
                break;
            case 'b2':
                return 'These are the service attributes that the customers considered as unimportant. DOST should not focus on these attributes and aspects of public service delivery which have no impact on the customers\' satisfaction.';
                break;
            case 'b3':
                return 'These are the service attributes that the customers considered as neither important nor unimportant DOST may or may not focus on these attributes and aspects of public service delivery which do not necessarily provide positive impact on the customers\' satisfaction.';
                break;
            case 'b4':
                return 'These are the service attributes that the customer considered as important. DOST should focus on these attributes and aspects of public service delivery which do not necessarily provide positive impact on the customers\' satisfaction.';
                break;
            case 'b5':
                return 'These are the service attributes that the customers considered as the most important. DOST agency should focus on these attributes and aspects of public service delivery which woll have the most impact on the customers\' satisfaction.';
                break;
            default:
                return '';
        }
    }
}
