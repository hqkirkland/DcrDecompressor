using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using ZLibNet;

namespace DcrDecompressor
{
    class Program
    {
        static byte[] Outbuf = new byte[1];
        static int[] BlockOffsets = new int[0];

        static String SourceFile;
        static String SourceFolder;
        static String OutputFolder;

        static void Main(string[] args)
        {
            Console.WriteLine("########################################");
            Console.WriteLine("||  Nodebay.com - Secret softare!!1!  ||");
            Console.WriteLine("########################################");

            Console.Write(">> Source Folder: ");
            SourceFolder = Console.ReadLine().TrimEnd("\\".ToCharArray());

            Console.Write(">> Source File: ");
            SourceFile = Console.ReadLine();

            Console.Write(">> Locate block index offsets? [Y/N]: ");
            
            if (ConsoleKey.Y == Console.ReadKey().Key)
            {
                byte[] SearchBytes = File.ReadAllBytes(SourceFolder + "\\" + SourceFile);

                for (int i = 0; i < SearchBytes.Length; i++)
                {
                    if (SearchBytes[i] == 0x78 && SearchBytes[i + 1] == 0xDA)
                    {
                        Array.Resize<int>(ref BlockOffsets, BlockOffsets.Length + 1);
                        BlockOffsets[BlockOffsets.Length - 1] = i;
                    }
                }
            }

            else
            {
                Console.Write("\n>> Enter file's block offsets (Format: 1, 2, 3, 4): ");

                String List = Console.ReadLine();

                String[] OffsetList = List.Split(", ".ToCharArray(), StringSplitOptions.RemoveEmptyEntries);
                BlockOffsets = new int[OffsetList.Length];

                int i = 0;

                foreach (String Offset in OffsetList)
                {
                    BlockOffsets[i] = int.Parse(OffsetList[i]);
                }
            }

            Console.WriteLine();
            Console.Write(">> Output Folder: ");
            OutputFolder = Console.ReadLine().TrimEnd("\\".ToCharArray());

            GetBlocks();

            return;
        }

        static void GetBlocks()
        {
            int CurrentBlock = 1;

            foreach (int BlockOffset in BlockOffsets)
            {
                FileStream DcrStream = File.Open(SourceFolder + "\\" + SourceFile, FileMode.Open, FileAccess.Read);
                DcrStream.Seek(BlockOffset, SeekOrigin.Begin);

                using (ZLibStream DeflateStream = new ZLibStream(DcrStream, CompressionMode.Decompress))
                {
                    using (MemoryStream MemStream = new MemoryStream(1))
                    {
                        DeflateStream.CopyTo(MemStream);

                        using (FileStream DcrUncompressed = File.Open(OutputFolder + "\\" + SourceFile.TrimEnd(".dcr".ToCharArray()) + "_Block" + CurrentBlock.ToString() + "_" + BlockOffset + ".bin", FileMode.OpenOrCreate))
                        {
                            Array.Resize<byte>(ref Outbuf, (int)(MemStream.Length));

                            using (MemoryStream NewStream = new MemoryStream(Outbuf))
                            {
                                MemStream.WriteTo(NewStream);

                                DcrUncompressed.Write(Outbuf, 0, (int)(MemStream.Length));
                                DcrUncompressed.Flush();
                            }
                        }
                    }
                }

                CurrentBlock++;
            }
        }
    }
}
