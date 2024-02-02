/**
 * Representa a plataforma.
 */
export default interface Platform {
	id: number,
	name: string,
	short_name: string,
	icon_path?: string,
	icon: string,
	created_at: string,
	updated_at: string,
	supported_file_extensions: any[],
};
