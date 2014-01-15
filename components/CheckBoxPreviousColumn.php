<?php

/**
 * CCheckBoxColumn represents a grid view column of checkboxes.
 *
 * CCheckBoxColumn supports no checking (read-only), single check and multiple checking.
 * The mode is determined according to {@link selectableRows}. When in multiple checking mode, the header cell will display
 * an additional checkbox, clicking on which will check or uncheck all of the checkboxes in the data cells.
 * The header cell can be customized by {@link headerTemplate}.
 *
 * Additionally selecting a checkbox can select a grid view row (depending on {@link CGridView::selectableRows} value) if
 * {@link selectableRows} is null (default).
 *
 * By default, the checkboxes rendered in data cells will have the values that are the same as
 * the key values of the data model. One may change this by setting either {@link name} or
 * {@link value}.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class CheckBoxPreviousColumn extends CCheckBoxColumn
{
    public $orientation = 'prevAll';
	/**
	 * Initializes the column.
	 * This method registers necessary client script for the checkbox column.
	 */
	public function init()
	{
		if(isset($this->checkBoxHtmlOptions['name']))
			$name=$this->checkBoxHtmlOptions['name'];
		else
		{
			$name=$this->id;
			if(substr($name,-2)!=='[]')
				$name.='[]';
			$this->checkBoxHtmlOptions['name']=$name;
		}
		$name=strtr($name,array('['=>"\\[",']'=>"\\]"));

                $js=<<<EOD
jQuery(document).on('click', "input[name='$name']", function() {
        var cc = this.checked;
        $(this).parents('tr').eq(0).{$this->orientation}('tr').find('input[type=checkbox]').each(function(x, item){
                item.disabled = item.checked = cc;
        });
                        
        return true;
});
EOD;
            Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,$js);
	}

}

?>
