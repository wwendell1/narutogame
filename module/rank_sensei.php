<?php if($_SESSION['usuario']['msg_vip']){?>
	<script type="text/javascript">
		head.ready(function () {
		$(document).ready(function() {
		if(!$.cookie("rank_ninjas")){
		$("#dialog").dialog({ 
			width: 540,
			height: 460, 
			title: '<?php echo t('ranks.pop_up'); ?>', 
			modal: true,
			close: function(){
				$.cookie("rank_ninjas", "foo", { expires: 1 });
			}
		
			});
		}
		});
		});
	</script>
<?php }?>
<?php
	$_POST['vila'] = !isset($_POST['vila']) ? $basePlayer->getAttribute('id_vila') : (int)decode($_POST['vila']);
	$_POST['sensei'] = !isset($_POST['sensei']) ? "00" : (int)decode($_POST['sensei']);
	$_POST['from'] = !isset($_POST['from']) ? 0 : decode($_POST['from']);
	
	if(!is_numeric($_POST['vila']) || !is_numeric($_POST['from']) || !is_numeric($_POST['sensei'])) {
		redirect_to("negado");	
	}

	$where = isset($_POST['vila']) && is_numeric($_POST['vila']) && $_POST['vila'] > 0 ? " AND a.id_vila=" . $_POST['vila'] : "";
	$where .= isset($_POST['sensei']) && is_numeric($_POST['sensei']) && $_POST['sensei'] > 0 ? " AND a.id_sensei=" . $_POST['sensei'] : "";
	//$where .= isset($_POST['nome']) && $_POST['nome'] ? " AND MATCH(a.nome) AGAINST ('*" . addslashes($_POST['nome']) . "*' IN BOOLEAN MODE)" : "";
	$where .= isset($_POST['nome']) && $_POST['nome'] ? " AND a.nome LIKE '%" . addslashes($_POST['nome']) . "%'" : "";
?>
<div id="dialog" style="display:none">
	<div style="background:url(<?php echo img()?>layout/popup/Rank.png); background-repeat:no-repeat; width:495px !important; height: 417px !important;">
		<div style="position:relative; width:280px; top:200px; padding-left: 18px;">
			
			<b><a href="index.php?secao=vantagens" class="linksSite3" style="font-size:16px"><?php echo t('ranks.vantagens_titulo'); ?></a></b><br /><br />
			<ul style="margin:0; padding:0;">
				<li style="margin-bottom:5px">
					<b><a href="index.php?secao=vantagens" class="linksSite3"><?php echo t('ranks.livro_reg'); ?></a></b><br />
					<?php echo t('ranks.livro_reg2'); ?>
				</li><br />
				<li style="margin-bottom:5px">
					<b><a href="index.php?secao=vantagens" class="linksSite3"><?php echo t('ranks.spy_ninja'); ?></a></b><br />
					<?php echo t('ranks.spy_ninja2'); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="titulo-secao"><p><?php echo t('titulos.rank_sensei'); ?></p></div>
<br />
<script type="text/javascript">
    google_ad_client = "ca-pub-9166007311868806";
    google_ad_slot = "5761438173";
    google_ad_width = 728;
    google_ad_height = 90;
</script>
<!-- Ranking -->
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<br />
<form method="post">

    <table width="730" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td height="49" align="left" colspan="7" class="subtitulo-home">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="color:#FFFFFF"><?php echo t('ranks.filtros'); ?></b></td>
        </tr>
      <tr >
        <td height="34" align="center">
		<b style="font-size:16px"><?php echo t('ranks.vila'); ?></b><br />
		<select name="vila" id="vila">
          <option value="<?php echo encode("00") ?>">Geral</option>
          <?php
          	$qVila = Recordset::query("SELECT *, nome_".Locale::get()." AS nome FROM vila WHERE inicial='1'", true);
          	
			foreach($qVila->result_array() as $rVila) {
				$selected = $_POST['vila'] == $rVila['id'] ? "selected='selected'" : "";
				echo "<option value='" . encode($rVila['id']) . "' $selected>" . htmlentities($rVila['nome']) . "</option>";	
			}
		  ?>
        </select>
		</td>
        <td align="center">
			<b style="font-size:16px">Sensei</b><br />
			<select name="sensei" id="sensei">
			<option value="<?php echo encode("00") ?>">Todos</option>
			 <?php
				$qSensei = Recordset::query("SELECT * FROM sensei", true);
				
				foreach($qSensei->result_array() as $rSensei) {
					$selected = $_POST['sensei'] == $rSensei['id'] ? "selected='selected'" : "";
					echo "<option value='" . encode($rSensei['id']) . "' $selected>" . $rSensei['nome'] . "</option>";	
				}
			  ?>
			</select>
		</td>
        <td  align="center">
			<b style="font-size:16px"><?php echo t('ranks.posicao'); ?></b><br />
			<select name="from" id="from">
			 <?php        
				$rTotal = Recordset::query("
					SELECT
						COUNT(a.id) as total
					
					FROM 
						ranking_sensei a 
						
					WHERE 1=1 
						 $where
				")->row_array();
				
				for($f = 0; $f <= $rTotal['total']; $f += 50) {
					$selected = $_POST['from'] == $f ? "selected='selected'" : "";
					echo "<option value='" . encode($f) . "' $selected>" . ($f + 1) . " ".t('geral.ate')." " . ($f + 50) . "</option>";	
				}
			?>
       		</select>
		</td>
        <td  height="34" align="center">
			<b style="font-size:16px"><?php echo t('ranks.nome'); ?></b><br />
			<input type="text" name="nome" value="<?php echo isset($_POST['nome']) ? addslashes($_POST['nome']) : '' ?>" />
       </td>
        <td width="80"  align="center"><input type="submit" class="button" value="<?php echo t('geral.filtrar')?>" /></td>
      </tr>
    </table>
    <br />
<table width="730" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="49" class="subtitulo-home"><table width="730" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="90" align="center"><b style="color:#FFFFFF"><?php echo t('ranks.posicao'); ?></b></td>
            <td width="160" align="center"><b style="color:#FFFFFF"><?php echo t('ranks.nome'); ?></b></td>
            <td width="50" align="center"><b style="color:#FFFFFF">Desafio Atual</b></td>
            <td width="100" align="center"><b style="color:#FFFFFF">Sensei</b></td>
            <td width="100" align="center"><b style="color:#FFFFFF"><?php echo t('ranks.pontos'); ?></b></td>
        	<td width="130" align="center"><b style="color:#FFFFFF"><?php echo t('ranks.personagem'); ?></b></td>
          </tr>
        </table></td>
      </tr>
    </table>
<table width="730" border="0" cellpadding="2" cellspacing="0">
		<?php
			//$i = $basePlayer->getVIPItem(array(20185,20186,20187));
			
			$vantagem_espiao		= $basePlayer->hasItem(array(2019, 2020, 2021));
			$vantagem_conquista		= $basePlayer->vip;
			$vantagem_equipamento	= $basePlayer->hasItem(array(21880, 21881, 21882));
			$cn						= 0;
			
			$order = (int)$_POST['sensei'] ? "posicao_sensei" : "posicao_geral";
            $query = Recordset::query("
				SELECT 
					a.*
				FROM 
					ranking_sensei a
				WHERE 1=1
               
                     $where
                
                ORDER BY $order ASC LIMIT {$_POST['from']}, 50");
			
            while($r = $query->row_array()) {
				$posicao = isset($_POST['sensei']) && is_numeric($_POST['sensei']) && $_POST['sensei'] > 0 ? $r['posicao_sensei'] : $r['posicao_geral'];
                $cor	 = ++$cn % 2 ? "class='cor_sim'" : "class='cor_nao'";
                if($posicao <= 3){
                    $posRanking = "amarelo";
					$posRanking2 = "font-weight: bold";
                } else {
                    $posRanking = "";
					$posRanking2 = "";
                }
				($r['id_player'] == $basePlayer->id) ? $cor="class='cor_roxa'" : "";
				
				$qSensei = Recordset::query("SELECT * FROM sensei WHERE id=".$r['id_sensei'], true)->row_array();

        ?>
      <tr <?php echo $cor ?>>
        <td width="90" align="center" style="font-size: 13px; <?php echo $posRanking2 ?>" class="<?php echo $posRanking ?>"><?php echo $posicao ?>&ordm;
        <br /><img src="<?php echo img() ?>layout/bandanas/<?php echo $r['id_vila'] ?>.png" width="48" height="24" />
        </td>
        <td width="160" height="34" align="left" nowrap="nowrap">
		<a class="linkTopo <?php echo $posRanking ?>" style="font-size: 13px; <?php echo $posRanking2 ?>" href="javascript:void(0)" onclick="playerProfile('<?php echo urlencode(encode($r['id_player'])) ?>')"><?php echo player_online($r['id_player'], true)?><?php echo $r['nome'] ?></a>
        <br /><?php echo $r['titulo_' . Locale::get()] ?>
        </td>
        <td width="50" align="center"><p><?php echo $r['desafio'] ?></p></td>
        <td width="100" align="center"><p><?php echo $qSensei['nome'] ?></p></td>
        <td width="100" align="center"><p><?php echo $r['pontos'] ?></p></td>
        <td width="130" align="center"><img src="<?php echo img() ?>/layout<?php echo LAYOUT_TEMPLATE?>/dojo/<?php echo $r['id_classe'] ?><?php echo LAYOUT_TEMPLATE=="_azul" ? ".jpg":".png"?>" width="126" height="44" /></td>
      </tr>
	  <tr height="4"></tr>
      <?php
			}
	  ?>
    </table>
</form>