export interface IMonthBudget {
    color: string | null;
    description: string | null;
    icon: string | null;
    id: number | string | null;
    name: string | null;
    percentage: number;
    type: "expense" | "income";
    user_id: number | null;
    [key: string]: any;
}
