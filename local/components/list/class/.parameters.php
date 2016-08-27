<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

try
{
  if (!Main\Loader::includeModule('iblock'))
		throw new Main\LoaderException(Loc::getMessage('LIST_PARAMETERS_IBLOCK_MODULE_NOT_INSTALLED'));

    $iblockTypes = \CIBlockParameters::GetIBlockTypes(Array("-" => " "));

  	$iblocks = array(0 => " ");
  	if (isset($arCurrentValues['IBLOCK_TYPE']) && strlen($arCurrentValues['IBLOCK_TYPE']))
  	{
  	    $filter = array(
  	        'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
  	        'ACTIVE' => 'Y'
  	    );
  	    $rsIBlock = \CIBlock::GetList(array('SORT' => 'ASC'), $filter);
  	    while ($arIBlock = $rsIBlock -> GetNext())
  	    {
  	        $iblocks[$arIBlock['ID']] = $arIBlock['NAME'];
  	    }
  	}

    $sortFields = array(
  		'ID' => Loc::getMessage('LIST_PARAMETERS_SORT_ID'),
  		'NAME' => Loc::getMessage('LIST_PARAMETERS_SORT_NAME'),
  		'ACTIVE_FROM' => Loc::getMessage('LIST_PARAMETERS_SORT_ACTIVE_FROM'),
  		'SORT' => Loc::getMessage('LIST_PARAMETERS_SORT_SORT')
  	);

    $sortDirection = array(
      'ASC' => Loc::getMessage('LIST_PARAMETERS_SORT_ASC'),
      'DESC' => Loc::getMessage('LIST_PARAMETERS_SORT_DESC')
    );

  $arComponentParameters = array(
  	"GROUPS" => array(
  	),
  	"PARAMETERS" => array(
      'IBLOCK_TYPE' => Array(
  				'PARENT' => 'BASE',
  				'NAME' => Loc::getMessage('LIST_PARAMETERS_IBLOCK_TYPE'),
  				'TYPE' => 'LIST',
  				'VALUES' => $iblockTypes,
  				'DEFAULT' => '',
  				'REFRESH' => 'Y'
  			),
        'IBLOCK_ID' => array(
    				'PARENT' => 'BASE',
    				'NAME' => Loc::getMessage('LIST_PARAMETERS_IBLOCK_ID'),
    				'TYPE' => 'LIST',
    				'VALUES' => $iblocks
    			),
        'COUNT' =>  array(
  				'PARENT' => 'BASE',
  				'NAME' => Loc::getMessage('LIST_PARAMETERS_COUNT'),
  				'TYPE' => 'STRING',
  				'DEFAULT' => '0'
  			),
        'CACHE_TIME' => array(
  				'DEFAULT' => 3600
  			),
        'SORT_FIELD' => array(
  				'PARENT' => 'BASE',
  				'NAME' => Loc::getMessage('LIST_PARAMETERS_SORT_FIELD'),
  				'TYPE' => 'LIST',
  				'VALUES' => $sortFields
			  ),
        'SORT_DIRECTION' => array(
  				'PARENT' => 'BASE',
  				'NAME' => Loc::getMessage('LIST_PARAMETERS_SORT_DIRECTION'),
  				'TYPE' => 'LIST',
  				'VALUES' => $sortDirection
			  ),
  	),
  );
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
?>
