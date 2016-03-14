<?php

/**
 * dashboard actions.
 *
 * @package    e4cc
 * @subpackage dashboard
 * @author     cubiascaceres@gmail.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions {

    /**
     * Executes index action
     */
    public function executeIndex() {
        # Build first Chart
        $sSiteQuery = "select s.site_name, s.panel_color from site s";
        $aSite = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sSiteQuery);
        $aCounter = array();
        foreach ($aSite as $aSiteRecord) {
            $aCounter[$aSiteRecord['site_name']] = array(
                'counter' => 0,
                'panel_color' => $aSiteRecord['panel_color']
            );
        }
        $sCounterBySiteQuery = "SELECT s.site_name, COUNT(DISTINCT i.id) as 'inscription_per_site'"
                . " FROM inscription i "
                . " Left Join course c ON c.id = i.course_id "
                . " left join class_room cr on cr.id = c.class_room_id"
                . " Left Join site s ON s.id = cr.site_id"
                . " WHERE i.is_active = 1 and s.is_active = 1"
                . " GROUP BY s.site_name";
        $aCounterBySite = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sCounterBySiteQuery);
        foreach ($aCounterBySite as $aCounterRecord) {
            if (array_key_exists($aCounterRecord['site_name'], $aCounter)) {
                $aCounter[$aCounterRecord['site_name']]['counter'] = $aCounterRecord['inscription_per_site'];
            }
        }
        $this->aSite = $aCounter;
        $this->oSiteCollection = Doctrine_Core::getTable("Site")->findByIsActive(1);
    }

    public function executeBuildPieChart() {
        $sCounterPerLevelPerSite = "select *, (counter * 100 / total_count) as 'percentage' from"
                . " (select s.site_name, lvl.level_name, count(i.id) 'counter',"
                . "(select count(i2.id) from inscription i2) as 'total_count'"
                . " from inscription i"
                . " left join course c on c.id = i.course_id"
                . " left join level lvl on lvl.id = c.level_id"
                . " left join class_room cr on cr.id = c.class_room_id"
                . " left join site s on s.id = cr.site_id"
                . " where i.is_active = 1"
                . " group by s.site_name, lvl.level_name) temp order by 1";
        $aData = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sCounterPerLevelPerSite);
        $aCategories = array();
        $aPieData = array();
        foreach ($aData as $aRecord) {
            if (!in_array($aRecord['site_name'], $aCategories)) {
                array_push($aCategories, $aRecord['site_name']);
            }
            if (!array_key_exists($aRecord['site_name'], $aPieData)) {
                $aPieData[$aRecord['site_name']] = new PieDonutChart();
            }
            $oPieChart = $aPieData[$aRecord['site_name']];
            $oPieChart->addY($aRecord['percentage']);
            $oPieChart->addCategory($aRecord['level_name']);
            $oPieChart->addData(doubleval($aRecord['percentage']));
        }
        $sJsonData = array('categories' => $aCategories, 'aData' => $aPieData);
        $this->getResponse()->setContent(json_encode($sJsonData));
        return sfView::NONE;
    }

    public function executeBuildBarChart() {
        $sEvaluationDates = "select distinct date_format(eva.evaluation_date, '%b-%Y') as  'eva_date',"
                . " date_format(eva.evaluation_date, '%Y%m%d') as 'raw_date'"
                . " from evaluation eva order by eva.evaluation_date";
        $aEvaluationDate = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sEvaluationDates);
        $aTrendAxis = array();
        $aRawDates = array();
        foreach ($aEvaluationDate as $aDateRecord) {
            array_push($aTrendAxis, $aDateRecord['eva_date']);
            array_push($aRawDates, $aDateRecord['raw_date']);
        }
        $sQueryEvalperCoach = "select count(eva.id) as 'counter', si.site_name as 'site_name',"
                . " date_format(eva.evaluation_date, '%Y%m%d') as 'eva_month'"
                . " from evaluation eva"
                . " inner join inscription ins on ins.id = eva.inscription_id"
                . " inner join course co on co.id = ins.course_id"
                . " inner join class_room cr on cr.id = co.class_room_id"
                . " inner join site si on si.id = cr.site_id"
                . " group by date_format(eva.evaluation_date, '%Y%m%d'), si.site_name"
                . " order by eva.evaluation_date asc";
        $aDataPerCoach = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sQueryEvalperCoach);
        $aAggregation = array();
        foreach ($aDataPerCoach as $aRecord) {
            $aAggregation[$aRecord['site_name']][$aRecord['eva_month']] = intval($aRecord['counter']);
        }
        foreach ($aRawDates as $sMonth) {
            foreach (array_keys($aAggregation) as $sSite) {
                if (!array_key_exists($sMonth, $aAggregation[$sSite])) {
                    $aAggregation[$sSite][$sMonth] = 0;
                    ksort($aAggregation[$sSite]);
                }
            }
        }
        $aSerie = array();
        foreach ($aAggregation as $sSiteName => $aValues) {
            array_push($aSerie, array(
                'name' => $sSiteName,
                'data' => array_values($aValues)
            ));
        }
        $aData = array(
            'xAxis' => $aTrendAxis,
            'series' => $aSerie
        );
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

    public function executeBuildTrendChart(sfWebRequest $oWebRequest) {
        $iSiteId = $oWebRequest->getParameter('site_id');
        # Build Trend Chart
        $sEvaluationDates = "select distinct date_format(eva.evaluation_date, '%d-%b-%Y') as  'eva_date',"
                . " date_format(eva.evaluation_date, '%Y%m%d') as 'raw_date'"
                . " from evaluation eva order by eva.evaluation_date";
        $aEvaluationDate = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sEvaluationDates);
        $aTrendAxis = array();
        $aRawDates = array();
        foreach ($aEvaluationDate as $aDateRecord) {
            array_push($aTrendAxis, $aDateRecord['eva_date']);
            array_push($aRawDates, $aDateRecord['raw_date']);
        }
        $sQueryTrend = "SELECT temp_table.coach as 'coach', temp_table.evaluation_date as 'evaluation_date',"
                . " AVG(temp_table.final_score) as 'final score' FROM(select p.username as 'coach',"
                . " (select sum(g.grade_score) as 'grades' from grade g where g.evaluation_id = eva.id group by g.evaluation_id) as 'final_score',"
                . " DATE_FORMAT(eva.evaluation_date, '%Y%m%d') as 'evaluation_date'"
                . " from evaluation eva "
                . " left join `user` u on u.id = eva.user_id "
                . " left join person p on p.id = u.person_id"
                . " left join inscription ins on ins.id = eva.inscription_id"
                . " left join course co on co.id = ins.course_id"
                . " left join class_room cr on cr.id = co.class_room_id"
                . " left join site si on si.id = cr.site_id"
                . " where si.id = {$iSiteId} order by 1)temp_table GROUP BY temp_table.coach, temp_table.evaluation_date";
        $aDataPerCoach = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sQueryTrend);
        $aTrendSeries = array();
        foreach ($aDataPerCoach as $aCoachRecord) {
            $aTrendSeries[$aCoachRecord['coach']][$aCoachRecord['evaluation_date']] = intval($aCoachRecord['final score']);
        }
        foreach ($aRawDates as $sEvaluationDate) {
            foreach (array_keys($aTrendSeries) as $sKeyCoach) {
                if (!array_key_exists($sEvaluationDate, $aTrendSeries[$sKeyCoach])) {
                    $aTrendSeries[$sKeyCoach][$sEvaluationDate] = 0;
                    ksort($aTrendSeries[$sKeyCoach]);
                }
            }
        }
        $aSerie = array();
        foreach ($aTrendSeries as $sCoachName => $aValues) {
            array_push($aSerie, array(
                'name' => $sCoachName,
                'data' => array_values($aValues)
            ));
        }
        $aData = array(
            'xAxis' => $aTrendAxis,
            'series' => $aSerie
        );
        $this->getResponse()->setContent(json_encode($aData));
        return sfView::NONE;
    }

}
