<?
/**
 * @author Artem Petelin
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

\Bitrix\Main\Loader::includeModule("iblock");

class classListComponents extends CBitrixComponent
  {

    /**
     * prepare input parameters
     * @param array $arParams
     * @return array
     */
  public function onPrepareComponentParams($params)
  {
    $result = array(
      'IBLOCK_TYPE' => trim($params['IBLOCK_TYPE']),
      'IBLOCK_ID' => intval($params['IBLOCK_ID']),
      'COUNT' => intval($params['COUNT']),
      'SORT_FIELD' => strlen($params['SORT_FIELD']) ? $params['SORT_FIELD'] : 'ID',
      'SORT_DIRECTION' => $params['SORT_DIRECTION'] == 'ASC' ? 'ASC' : 'DESC',
      'CACHE_TIME' => intval($params['CACHE_TIME']) > 0 ? intval($params['CACHE_TIME']) : 3600
    );
    return $result;
  }

    /**
     * check required modules
     * @throws LoaderException
     */
  protected function checkModules()
  {
    if (!Main\Loader::includeModule('iblock'))
      throw new Main\LoaderException(Loc::getMessage('LIST_CLASS_IBLOCK_MODULE_NOT_INSTALLED'));
  }

    /**
     * get list elements
     * @return array
     */
  public function listElements()
  {
    $nav = new \Bitrix\Main\UI\PageNavigation('news');
    $nav -> allowAllRecords(true)
      -> setPageSize($this -> arParams['COUNT'])
      -> initFromUri();

    $items = \Bitrix\Iblock\ElementTable::getList(array(
      'filter' => array(
          'IBLOCK_ID' => $this -> arParams['IBLOCK_ID'],
          'ACTIVE' => 'Y'
      ),
      'order' => array(
          $this -> arParams['SORT_FIELD'] => $this -> arParams['SORT_DIRECTION']
      ),
      'count_total' => true,
      'offset' => $nav -> getOffset(),
      'limit' => $nav -> getLimit(),
    ));

    $this -> arResult["NAV"] = $nav -> setRecordCount($items -> getCount());
    $this -> arResult["ITEMS"] = $items -> fetchAll();

    return $arResult;
  }

    /**
     * perform login component
     */
  public function executeComponent()
  {
    $this -> checkModules();
    $this -> listElements();
    $this -> includeComponentTemplate();
  }
   
}
?>
