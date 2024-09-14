using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace almanR
{
    internal class DBuser
    {
        public static MySqlConnection GetConnection()
        {
            string sql = "datasource=localhost;port=3306;username=root;password=;database=kursinis_heterogenine";
            MySqlConnection con = new MySqlConnection(sql);

            try
            {
                con.Open();
            }
            catch (MySqlException ex)
            {

                MessageBox.Show("MySQL Connection! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            return con;
        }

        public static void editUser(user usr, string id)
        {
            string sql = "UPDATE users set blogger_name=@firstName, blogger_fname=@lastName, blogger_email=@email, admin=@role WHERE blogger_id=@UserID";
            MySqlConnection con = GetConnection();
            MySqlCommand cmd = new MySqlCommand(sql, con);
            cmd.CommandType = CommandType.Text;
            cmd.Parameters.Add("@UserID", MySqlDbType.VarChar).Value = id;
            cmd.Parameters.Add("@firstName", MySqlDbType.VarChar).Value = usr.firstName;
            cmd.Parameters.Add("@lastName", MySqlDbType.VarChar).Value = usr.lastName;
            cmd.Parameters.Add("@email", MySqlDbType.VarChar).Value = usr.email;
            cmd.Parameters.Add("@role", MySqlDbType.Int16).Value = usr.role;

            try
            {
                cmd.ExecuteNonQuery();
                MessageBox.Show("Edited successfully! \n", "Success:", MessageBoxButtons.OK, MessageBoxIcon.Information);

            }
            catch (MySqlException ex)
            {

                MessageBox.Show("Editing failed! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con.Close();
        }

        public static void displayAndSearch(string query, DataGridView dgv)
        {
            string sql = query;
            MySqlConnection con = GetConnection();
            MySqlCommand cmd = new MySqlCommand(sql, con);
            MySqlDataAdapter adp = new MySqlDataAdapter(cmd);
            DataTable tbl = new DataTable();
            adp.Fill(tbl);
            dgv.DataSource = tbl;
            con.Close();

        }
    }
}
