<?php
 /**
  * Agregando  los campos al front-end
  */

  function thim_course_info() {
	$course    = LP()->global['course'];
	$course_id = get_the_ID();

	$course_skill_level = get_post_meta( $course_id, 'thim_course_skill_level', true );
	$course_language    = get_post_meta( $course_id, 'thim_course_language', true );
	$course_duration    = get_post_meta( $course_id, 'thim_course_duration', true );

	$course_modalidad         = get_post_meta( $course_id, 'thim_course_modalidad', true );
	$course_proximo_inicio    = get_post_meta( $course_id, 'thim_course_proximo_inicio', true );
	$course_proximo_termino    = get_post_meta( $course_id, 'thim_course_proximo_termino', true );
	$course_proximo_inicio_two = get_post_meta( $course_id, 'thim_course_proximo_inicio_two', true );
	$thim_course_cierre_matriculas = get_post_meta( $course_id, 'thim_course_cierre_matriculas',true);
	$thim_course_assoc_test = get_post_meta( $course_id, 'assoc_test',true);
	

	?>
	<div class="thim-course-info">
		<h3 class="title"><?php esc_html_e( 'Course Features', 'eduma' ); ?></h3>
		<ul>
			<?php foreach ($course_proximo_inicio as $key => $c) { ?>
				<li class="duration-feature">
					<i class="fa fa-calendar"></i>
					<span class="label"><?php esc_html_e( 'Fecha de inicio', 'eduma' ); ?></span>
					<span class="value"><?php echo $c  ?></span>
				</li>
			<?php } ?>

			<?php foreach ($course_proximo_termino as $key => $c) { ?>
				<li class="duration-feature">
					<i class="fa fa-calendar-o"></i>
					<span class="label"><?php esc_html_e( 'Fecha de término', 'eduma' ); ?></span>
					<span class="value"><?php echo $c  ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $thim_course_cierre_matriculas ) ): ?>
			<?php foreach ($thim_course_cierre_matriculas as $key => $c) { ?>
				<li class="duration-feature">
					<i class="fa fa-calendar-o"></i>
					<span class="label"><?php esc_html_e( 'Cierre de matrículas', 'eduma' ); ?></span>
					<span class="value"><?php echo $c  ?></span>
				</li>
			<?php } ?>
			<?php endif; ?>

			<?php if ( ! empty( $course_modalidad  ) ): ?>
				<li class="duration-feature">
					<i class="fa fa-puzzle-piece"></i>
					<span class="label"><?php esc_html_e( 'Modalidad', 'eduma' ); ?></span>
					<span class="value"><?php echo $course_modalidad  ?></span>
				</li>
			<?php endif; ?>
			
			<?php if ( ! empty( $course_duration ) ): ?>
				<li class="duration-feature">
					<i class="fa fa-clock-o"></i>
					<span class="label"><?php esc_html_e( 'Duration', 'eduma' ); ?></span>
					<span class="value"><?php echo $course_duration; ?></span>
				</li>
			<?php endif; ?>



			<?php if ( ! empty( $course_skill_level ) ): ?>
				<li class="skill-feature">
					<i class="fa fa-tachometer"></i>
					<span class="label"><?php esc_html_e( 'Nivel', 'eduma' ); ?></span>
					<span class="value"><?php echo esc_html( $course_skill_level ); ?></span>
				</li>
			<?php endif; ?>
			<?php if ( ! empty( $course_language ) ): ?>
				<li class="language-feature">
					<i class="fa fa-language"></i>
					<span class="label"><?php esc_html_e( 'Language', 'eduma' ); ?></span>
					<span class="value"><?php echo esc_html( $course_language ); ?></span>
				</li>
			<?php endif; ?>

			<?php thim_course_certificate( $course_id ); ?>
			<li class="assessments-feature">
				<i class="fa fa-check-square-o"></i>
				<span class="label"><?php esc_html_e( 'Assessments', 'eduma' ); ?></span>
				<span class="value"><?php echo ( get_post_meta( $course_id, '_lp_course_result', true ) == 'evaluate_lesson' ) ? esc_html__( 'Yes', 'eduma' ) : esc_html__( 'Self', 'eduma' ); ?></span>
			</li>
			<?php if ( ! empty( $course_proximo_inicio_two ) ): ?>
			<?php foreach ($course_proximo_inicio_two as $key => $c) { ?>
				<li class="duration-feature">
					<i class="fa fa-calendar-o"></i>
					<span class="label"><?php esc_html_e( 'Próximo inicio', 'eduma' ); ?></span>
					<span class="value"><?php echo $c  ?></span>
				</li>
			<?php } ?>
			<?php endif; ?>

			<?php if(!empty( $thim_course_assoc_test )): ?>
				<li>
					<a href="<?= get_page_link($thim_course_assoc_test)  ?>" target="_blank" class=" event_register_submit event_auth_button"> <?php esc_html_e( 'Test Online', 'eduma' ); ?></a>
				</li>
			<?php  endif; ?> 





		</ul>
		<?php do_action( 'thim_after_course_info' ); ?>
	</div>
	<?php
}
