export interface ICategory {
    color: string | null;
    description: string | null;
    icon: string | null;
    id: number | string | null;
    month_budget_id: number | null;
    name: string | null;
    parent_category_id: number | string | null;
    user_id: number | null;
    [key: string]: any;
}
