<div id="primary" class="content-area">
<div class="container">
      
  <div class="page-grid">
  <div id="main" class="site-main">
                
    <div class="row">
      <div class='col-sm-12 col-lg-12'>
        <?php the_widget('best_shop_news_tags_widget', array('title'=>'News Tags') ); ?>
      </div>
    </div>
      <br/>
      
    <div class="row">
      <div class='col-sm-12 col-lg-12'>
        <?php the_widget('best_shop_news_marquee_widget', array('title'=>'News Marquee') ); ?>
      </div>
    </div>
      <br/>
      
     <div class="row">
      <div class='col-sm-12 col-lg-12'>
        <?php the_widget('best_shop_news_widget', array('title'=>'3 column', 'layout'=>'1', 'colums'=> 'col-md-4 col-sm-4 col-lg-4 col-xs-12' ) ); ?>
      </div>
    </div>   
       <br/>
      
    <div class="row">
      <div class='col-sm-9 col-lg-9'>
          
        <?php the_widget('best_shop_post_slider_widget', array('max_items'=>3,  'navigation'=>true) ); ?>
          
          
          
        <?php the_widget('best_shop_news_widget', array('title'=>'News 1', 'layout'=>'1', 'colums'=> 'col-md-6 col-sm-6 col-lg-6 col-xs-12' ) ); ?>

          
        <?php the_widget('best_shop_news_widget', array('title'=>'News 2', 'layout'=>'2', 'colums'=> 'col-md-4 col-sm-4 col-lg-4 col-xs-12' ) ); ?>

        <?php the_widget('best_shop_news_widget', array('title'=>'News 5', 'layout'=>'5', 'colums'=> 'col-md-6 col-sm-6 col-lg-6 col-xs-12' ) ); ?>
          
          <div class="row">
              <div class="col-sm-6 col-lg-6"><?php the_widget('best_shop_news_widget', array('title'=>'Double column 1', 'layout'=>'5', 'colums'=> 'col-md-12 col-sm-12 col-lg-12 col-xs-12' ) ); ?></div>
              <div class="col-sm-6 col-lg-6"><?php the_widget('best_shop_news_widget', array('title'=>'Double column 2', 'layout'=>'5', 'colums'=> 'col-md-12 col-sm-12 col-lg-12 col-xs-12' ) ); ?></div>
          </div>
          
      </div>
      <div class='col-sm-3 col-lg-3 template-home-sidebar'>
        <?php get_sidebar(); ?>
      </div>
    </div>
                
                
      
    </div>
    </div>
        
  </div>
</div>
