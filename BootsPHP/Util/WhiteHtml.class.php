<?php
namespace BootsPHP\Util;
/**
 * 白名单方式过滤HTML
 * @author ssdn@vip.qq.com
 * @uses
 * $whiteList = array(
	'b' => '', //标签
	'br' => '',
	'br/' => '',
	'p' => array(
		'align' => array(	//标签中可存在的属性
			'values' => array('left', 'right', 'center'),	//属性可允许的值
		), 
		'style' => array(
			'float' => array(
				'values' => array('left', 'right'),	//属性可允许的值
			),
		),
	), 
	'div' => array( //标签
		'align' => array(	//标签中可存在的属性
			'values' => array('left', 'right', 'center'),	//属性可允许的值
		), 
		'style' => array(
			'float' => array(
				'values' => array('left', 'right'),	//属性可允许的值
			),
		),
	), 
	'img' => array(	//标签
		'width' => array(	//标签中可存在的属性
			'grep' => '#^[1-9][0-9]{0,3}$#s',	//属性的正则校验规则
		), 
		'height' => array(
			'grep' => '#^[1-9][0-9]{0,3}$#s',
		), 
	),
);
$whiteHtml = new WhiteHtml($whiteList);
$whiteHtml->addGrep('a', 'href', '#^http://[a-z0-9/\.]*$#is');
$whiteHtml->addValues('b', '', array());
$whiteHtml->addGrep('img', 'src', '#^http://[a-z0-9/\.]*$#is');
$_SESSION['content'] = $whiteHtml->filter($_POST['content']);

 */

class WhiteHtml{

	/**
	 * 白名单
	 * @var array
	 */
	private $whiteList = array();

	public function __construct(array $whiteList = array()){
		$this->whiteList = $whiteList;
	}

	/**
	 * 添加HTML标签白名单
	 * @param string $label
	 */
	public function addLabel($label, array $rule = array()){
		$this->whiteList[$label] || $this->whiteList[$label] = $rule;
	}

	/**
	 * 为标签添加过滤规则的可允许值
	 * @param string $label 标签
	 * @param string $attribute 属性
	 * @param array $values 可允许的值
	 */
	public function addValues($label, $attribute, array $values){
		if (isset($this->whiteList[$label][$attribute]['grep'])){
			unset($this->whiteList[$label][$attribute]['grep']);
		}
		$this->whiteList[$label][$attribute]['values'] = $values;
	}

	/**
	 * 为标签添加正则过滤规则
	 * @param string $label 标签
	 * @param string $grep  过滤规则
	 */
	public function addGrep($label, $attribute, $grep){
		if (isset($this->whiteList[$label][$attribute]['values'])){
			unset($this->whiteList[$label][$attribute]['values']);
		}
		$this->whiteList[$label][$attribute]['grep'] = $grep;
	}

	/**
	 * 获取白名单
	 * @return array
	 */
	public function getWhiteList(){
		return $this->whiteList;
	}

	/**
	 * 执行过滤
	 * @param string $htmlcode
	 * @return string
	 */
	function filter($htmlcode){
		if (empty($htmlcode)){
			return '';
		}
		//只保留允许的标签
		$htmlcode = strip_tags($htmlcode, implode('', array_map(create_function('$key', 'return "<{$key}>";'), array_keys($this->whiteList))));
		foreach ($this->whiteList as $whiteLabel => $rule){
			$clean = ''; //某个白名单中的标签过滤后的HTML代码, 非所有标签都过滤后的HTML代码
			$unclean = $htmlcode; //正在过滤的代码, 可能是已经过滤过某些标签后的HTML代码
			$found = false;	//是否找到了标签进行处理
			while (($posLabelStart = strpos($unclean, "<{$whiteLabel}")) !== false){	//查找是否存在标签
				$found = true;
				$posLabelEnd = strpos($unclean, '>', $posLabelStart);	//找到此标签结束位置
				if ($posLabelEnd === false){
					break;	//找不到匹配结束标签, 直接退出
				}
				$label = substr($unclean, $posLabelStart, $posLabelEnd - $posLabelStart + 1);	//把这个标签的整段截取出来
				if (!$rule){ //没规则, 就把所有可能存在的属性干掉
					$label = "<{$whiteLabel}>";
				}elseif (is_array($rule)){	//如果有针对此标签的规则, 则根据规则检验
					$posFirstSpace = strpos($label, ' '); //查找第一个空格
					if ($posFirstSpace === false){ //没有空格的话, 也重新组装下此标签
						$label = "<{$whiteLabel}>";
					}else{
						$cleaned = "<{$whiteLabel}"; //标签内过滤后的属性字符串
						foreach ($rule as $attribute => $attributeRule){	//align => 'values' => array('left', 'right', 'center')
							if (($posAttribute = strpos($label, $attribute)) === false){
								continue;	//如果不存在此属性就继续查找其他属性
							}
							$posFirstDoubleQuote = strpos($label, '"', $posAttribute);	//查找第一个双引号
							$posFirstSingleQuote = strpos($label, "'", $posAttribute);	//查找第一个单引号
							//双引号不存在，或者在单引号后边
							if ($posFirstDoubleQuote === false || $posFirstDoubleQuote > $posFirstSingleQuote) {
								$posFirstQuote = strpos($label, "'", $posAttribute);	//查找第一个单引号
								$posSecondQuote = strpos($label, "'", $posFirstQuote + 1);	//查找第二个单引号
							}else{
								$posFirstQuote = $posFirstDoubleQuote;
								$posSecondQuote = strpos($label, '"', $posFirstQuote + 1);	//查找第二个双引号
							}
							$attstr = substr($label, $posFirstQuote + 1, $posSecondQuote - $posFirstQuote - 1);	//把属性字符串拿出来, +1: 前边的"不要. -1: 后边的"不要
							if ($attribute == 'style'){	//style的特例, 需要判断其中每一个值
								$attarray = explode(';', $attstr);	//获得style中的每个属性:值
								foreach ($attarray as $at => $va){
									$va = explode(':', $va);	//把每个属性拿出来比如 float => left, color => #fffff
									if (!$attributeRule[$va[0]]){	//如果不在白名单中
										unset($attarray[$at]);
										continue;
									}
									if ($attributeRule[$va[0]]['values'] && !in_array($va[1], $attributeRule[$va[0]]['values'])){
										unset($attarray[$at]);
										continue;
									}
									if ($attributeRule[$va[0]]['grep'] && !preg_match($attributeRule[$va[0]]['grep'], $va[1])){
										unset($attarray[$at]);
										continue;
									}
								}
								$attstr = $attarray ? ' style="' . implode(';', $attarray) . '"' : '';
								$cleaned .= $attstr;
							}else{
								//如果规定了只能允许的值, 但是属性值不在允许范围内, 过滤
								if (isset($attributeRule['values']) && in_array($attstr, $attributeRule['values'], true)){
									$cleaned .= " {$attribute}=\"{$attstr}\"";
								}
								//如果规定了值的正则, 则根据正则匹配过滤
								if (isset($attributeRule['grep']) && $attributeRule['grep'] && preg_match($attributeRule['grep'], $attstr)){
									$cleaned .= " {$attribute}=\"{$attstr}\"";
								}
							}
						}
						$label = $cleaned . '>';
					}
				}
				$unclean = substr_replace($unclean, $label, $posLabelStart, $posLabelEnd - $posLabelStart + 1);	//替换未过滤前的那段代码为过滤后的代码
				$clean .= substr($unclean, 0, $posLabelStart + strlen($label)); //把处理过的附加到此变量中保存
				$unclean = substr($unclean, $posLabelStart + strlen($label));	//未处理的代码
			}
			if ($found){ //没处理过不保存
				$htmlcode = $clean;	//保存清理过的代码
				if ($unclean){ //如果有处理完, 还剩下的, 就附加上
					$htmlcode .= $unclean;
				}
			}
		}
		return $htmlcode;
	}
}